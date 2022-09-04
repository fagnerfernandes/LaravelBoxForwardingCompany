<?php

namespace App\ExternalApi\Payments;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Iugu implements PaymentInterface
{
    public $url = 'https://api.iugu.com/v1';

    public $apiKeyProd;
    public $apikeyTest;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @var array
     */
    private $payer = [];

    public function __construct()
    {
        $this->apiKeyProd = env('IUGU_PRODKEY');
        $this->apikeyTest = env('IUGU_TESTKEY');
    }

    public function createCustomer($name, $email)
    {
        try {
            $data = ['name' => $name, 'email' => $email];

            $response = $this->post("/customers", $data);
            if (!empty($response['errors'])) {
                return $response['errors'];
            }
            return $response['id'];
        } catch (Exception $e) {
            throw new Exception("erro ao cadastrar o cliente: " . $e->getMessage());
        }
    }

    /**
     * Seta o pagamento
     */
    public function setPayer($user): void
    {
        if (is_array($user)) $user = (object)$user;

        $this->payer = [
            'address' => [
                'street' => $user->street,
                "number" => $user->number,
                "district" => $user->neighborhood,
                "city" => $user->city,
                "state" => $user->uf,
                "zip_code" => $user->zipcode,
                "complement" => $user->complement ?? '',
            ],
            'cpf_cnpj' => str_replace(['.', '-', '/'], '', $user->document),
            'name' => $user->name,
            'phone' => str_replace(['(', ')', '-', ' '], '', $user->phone),
            'email' => $user->email,
        ];

        $this->payer['customer_id'] = $this->createCustomer($user->name, $user->email);
    }

    public function addItem($description, $quantity, $price): void
    {
        $this->items[] = [
            'description' => $description,
            'quantity' => $quantity,
            'price_cents' => (int)ceil($price * 100),
        ];
    }

    /**
     * @param array $data
     * @return string
     */
    public function createToken($holder_name, $number, $cvv, $expiration): string
    {
        list($first_name, $last_name) = explode(' ', $holder_name, 2);
        list($month, $year) = explode('/', $expiration);
        $data = [
            'number' => $number,
            'verification_value' => $cvv,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'month' => trim($month),
            'year' => trim($year),
        ];

        try {
            $data = [
                'account_id' => $this->apikeyTest,
                'method' => 'credit_card',
                'test' => true,
                'data' =>  $data,
            ];

            $response = $this->post("/payment_token", $data);
            if (!empty($response['errors'])) {
                return $response['errors'];
            }
            return $response['id'];
        } catch (\Exception $e) {
            logger('Erro ao fazer o cadastro do cartao', [$e->getMessage(), $e->getLine()]);
            throw new Exception('Erro para gravar os dados do cartao: ' . $e->getMessage());
        }
    }

    public function creditCardPayment($order_id, $token, $installments): array
    {
        logger('PARAMETROS DA FUNCAO CREDIT CARD PAYMENT', func_get_args());
        try {

            $data = [
                'payer' => $this->payer,
                'items' => $this->items,
                'order_id' => $order_id,
                'email' => $this->payer['email'],
                //'method' => 'credit_card',
                'months' => $installments,
                'token' => $token,
                'notification_url' => env('POSTBACK_BASEURL') . $order_id,
            ];
            Log::debug('dados de pagamento', $data);

            $response = $this->post("/charge", $data);

            Log::error('RETORNO DA IUGU', $response);

            if (!empty($response['errors'])) {
                return ['success' => false, 'error' => $response['errors']];
            }

            return [
                'success' => true,
                'gateway_reference' => $response['invoice_id'],
                'url' => null,
                'due_date' => null,
            ];
        } catch (Exception $e) {
            Log::error('Erro ao gerar o pagamento direto', [$e->getMessage(), $e->getLine()]);
            throw new Exception('Houve um erro ao gerar a cobrança: ' . $e->getMessage());
        }
    }

    public function boletoPayment($order_id, $installments, $pay_with = 'boleto'): array
    {
        try {

            $data = [
                'payer' => $this->payer,
                'items' => $this->items,
                'order_id' => $order_id,
                'email' => $this->payer['email'],
                'due_date' => now()->addDays(3)->format('Y-m-d'),
                'notification_url' => env('POSTBACK_BASEURL') . $order_id,
                'payable_with' => ['bank_slip', 'pix'],
            ];

            // if ($pay_with == 'boleto') {
            //     $data['payable_with'] = ['bank_slip'];
            // } else {
            //     $data['payable_with'] = ['pix'];
            // }

            Log::debug('dados de pagamento', $data);

            $response = $this->post("/invoices", $data);

            logger('GERADA FATURA COM BOLETO E PIX', $response);

            if (!empty($response['errors'])) {
                return ['success' => false, 'error' => $response['errors']];
            }

            return [
                'success' => true,
                'gateway_reference' => $response['id'],
                'url' => $response['secure_url'],
                'due_date' => $response['due_date'],
                'qrcode' => $pay_with == 'pix' ? $response['pix']['qrcode_text'] : null,
            ];
        } catch (Exception $e) {
            Log::error('Erro ao gerar o pagamento direto', [$e->getMessage(), $e->getLine()]);
            throw new Exception($e->getMessage(), $e->getLine());
        }
    }

    public function plan($identifier, $months, $value_total)
    {
        logger('DADOS PARA CRIAR O PLANO', func_get_args());
        try {
            if ($this->planExists($identifier)) return $identifier;

            $value_total = $value_total * 100;
            $data = [
                'name' => (string)$identifier,
                'identifier' => (string)$identifier,
                'interval' => 1,
                'interval_type' => 'months',
                'value_cents' => (int)ceil($value_total / $months),
                'max_cycles' => $months,
            ];

            $response = $this->post('/plans', $data);
            logger('RESPOSTA IUGU A CRIACAO DO PLANO', $response);

            if (!empty($response['errors'])) {
                return $response['errors'];
            }
            return $response['identifier'];
        } catch (Exception $e) {
            logger('Erro ao criar um plano', [$e->getMessage(), $e->getLine()]);
            throw new Exception("Erro ao criar o plano: " . $e->getMessage());
        }
    }

    public function planExists($identifier): bool
    {
        try {
            $plan = $this->get("/plans/identifier/{$identifier}");
            if (!empty($plan['errors'])) return false;
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar o plano: " . $e->getMessage());
        }
    }

    public function subscribe($identifier, $token)
    {
        logger('DADOS RECEBIDOS PARA ASSINAR O PLANO', func_get_args());
        try {
            $data = [
                'two_step' => true,
                'suspend_on_invoice_expired' => true,
                'only_charge_on_due_date' => false,
                'plan_identifier' => $identifier,
                'customer_id' => $this->payer['customer_id'],
                'token' => $token,
                'notification_url' => env('POSTBACK_BASEURL') . $identifier,
            ];

            Log::debug('dados do plano', $data);

            $response = $this->post('/subscriptions', $data);
            if (!empty($response['errors'])) {
                return ['success' => false, 'error' => $response['errors']];
            }

            return [
                'success' => true,
                'gateway_reference' => $response['id'],
                'url' => null,
                'due_date' => null,
            ];
        } catch (Exception $e) {
            Log::error('erro ao processar o pagamento', [$e->getMessage(), $e->getLine()]);
            throw new Exception("Erro ao criar a assinatura: " . $e->getMessage());
        }
    }

    public function createInvoice($payment_form, $due_date)
    {
        
    }

    private function get($endpoint)
    {
        try {
            $url = $this->url . $endpoint . '?api_token=' . $this->apikeyTest;
            $response = Http::get($url);
            return $response->json();
        } catch (Exception $e) {
            logger('Erro na requisicao', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            throw new Exception("erro na requisicao: " . $e->getMessage());
        }
    }

    private function post($endpoint, $data)
    {
        try {
            $url = $this->url . $endpoint . '?api_token=' . $this->apikeyTest;
            $response = Http::post($url, $data);
            return $response->json();
        } catch (Exception $e) {
            logger('Erro na requisicao', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            throw new Exception("erro na requisicao: " . $e->getMessage());
        }
    }
}
