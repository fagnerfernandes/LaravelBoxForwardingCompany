<?php

namespace App\ExternalApi\Payments;

use Carbon\Carbon;
use PagarMe\Client;

class Pagarme implements PaymentInterface
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @var array
     */
    private $payer = [];

    private $pagarme;

    private $apiTokenProd;
    private $apiTokenTest;

    public function __construct()
    {
        $this->apiTokenProd = env('PAGARME_PRODKEY');
        $this->apiTokenTest = env('PAGARME_TESTKEY');

        $this->pagarme = new Client($this->apiTokenTest);
    }

    public function setPayer($user): void
    {
        if (is_array($user)) $user = (object)$user;

        $this->payer = [
            'address' => [
                'country' => 'br',
                'street' => $user->street,
                "street_number" => $user->number,
                "neighborhood" => $user->neighborhood,
                "city" => $user->city,
                "state" => $user->uf,
                "zipcode" => $user->zipcode,
                "complement" => $user->complement ?? '',
            ],
            'external_id' => (string)$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => 'individual',
            'country' => 'br',
            'documents' => [
                [
                    'type' => 'cpf',
                    'number' => str_replace(['.', '-', '/'], '', $user->document),
                ]
            ],
        ];

        if (!empty($user->phone)) {
            $this->payer['phone_numbers'] = [trim('+55'. str_replace(['(', ')', '-', ' '], '', $user->phone))];
        } else $this->payer['phone_numbers'] = [trim('+5511969159344')];
    }

    public function addItem($description, $qtd, $price): void
    {
        $totalItems = count($this->items);
        $this->items[] = [
            'id' => (string)($totalItems + 1),
            'title' => $description,
            'unit_price' => $price * 100,
            'quantity' => $qtd,
            'tangible' => false,
        ];
    }

    public function amount()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += ($item['unit_price'] * $item['quantity']);
        }
        return (float)$total;
    }

    public function createToken($holder_name, $number, $cvv, $expiration): string
    {
        try {
            list($month, $year) = explode('/', $expiration);
            $month = trim($month);
            $year = substr(trim($year), -2);

            $data = [
                'holder_name' => $holder_name,
                'number' => $number,
                'expiration_date' => "{$month}{$year}",
                'cvv' => $cvv,
            ];

            $response = $this->pagarme->cards()->create($data);
            return (string)$response->id;
        } catch (\Exception $e) {
            logger('erro ao fazer a criacao do token', [$e->getMessage(), $e->getLine()]);
            return 'Erro';
        }
    }

    public function boletoPayment($order_id, $installments): array
    {
        try {
            $data = [
                'amount' => ($this->amount() * 100),
                'payment_method' => 'boleto',
                'installments' => $installments,
                'postback_url' => env('POSTBACK_BASEURL') . $order_id,
                'customer' => collect($this->payer)->except('address'),
                'billing' => [
                    'name' => $this->payer['name'],
                    'address' => collect($this->payer['address'])->except('complement'),
                ],
                'async' => false,
                'items' => $this->items,
            ];

            logger('dados do pagamento', $data);
            $transaction = $this->pagarme->transactions()->create($data);

            return [
                'success' => true,
                'gateway_reference' => $transaction->id,
                'url' => $transaction->boleto_url,
                'due_date' => Carbon::parse($transaction->boleto_expiration_date)->format('Y-m-d'),
            ];
        } catch (\Exception $e) {
            logger('erro ao fazer o pagamento com boleto', [$e->getMessage(), $e->getLine()]);
            return ['success' => false];
        }
    }

    public function creditCardPayment($order_id, $token, $installments): array
    {
        try {
            $data = [
                'amount' => ($this->amount() * 100),
                'payment_method' => 'credit_card',
                'installments' => $installments,
                'postback_url' => env('POSTBACK_BASEURL') . $order_id,
                'customer' => collect($this->payer)->except('address'),
                'billing' => [
                    'name' => $this->payer['name'],
                    'address' => collect($this->payer['address'])->except('complement'),
                ],
                'async' => false,
                'items' => $this->items,
                'card_id' => $token
            ];

            logger('dados do pagamento', $data);
            $transaction = $this->pagarme->transactions()->create($data);

            return [
                'success' => true,
                'gateway_reference' => $transaction->id,
                'url' => null,
                'due_date' => null,
            ];
        } catch (\Exception $e) {
            logger('erro ao fazer o pagamento com cartao de credito', [$e->getMessage(), $e->getLine()]);
            return ['success' => false];
        }
    }

    public function createInvoice($payment_form, $due_date)
    {

    }

    public function directPayment($method, $order_id, $token = null, $installments = 1, $card_hash = null, $card_info = array())
    {

    }

    public function subscribe($identifier, $token)
    {
        try {
            $payer = $this->payer;
            $phone = str_replace('+55', '', $payer['phone_numbers'][0]);
            $ddd = substr($phone, 0, 2);
            $phone = substr($phone, 2);

            $payer['phone'] = [
                'ddd' => $ddd,
                'number' => $phone,
            ];

            $data = [
                'plan_id' => $identifier,
                'card_id' => $token,
                'customer' => $payer,
                'metadata' => [
                    'order_id' => $identifier,
                ],
                'postback_url' => env('POSTBACK_BASEURL') . $identifier,
            ];

            //dump($data);
            $response = $this->pagarme->subscriptions()->create($data);
            return [
                'success' => true,
                'gateway_reference' => $response->id,
                'url' => null,
                'due_date' => null,
            ];
        } catch (\Exception $e) {
            logger('erro ao fazer a assinatura do plano', [$e->getMessage(), $e->getLine()]);
            return ['success' => false];
        }
    }

    public function plan($identifier, $months, $value_total)
    {
        try {
            $days = $months * 30;
            $value_monthly = ($value_total / $months) * 100;

            $data = [
                'amount' => $value_monthly,
                'days' => $days,
                'installments' => $months,
                'name' => (string)$identifier,
            ];
            $response = $this->pagarme->plans()->create($data);

            return $response->id;
        } catch (\Exception $e) {
            logger('erro ao criar o plano', [$e->getMessage(), $e->getLine()]);
            return 'Erro';
        }
    }
}
