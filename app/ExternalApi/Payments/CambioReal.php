<?php

namespace App\ExternalApi\Payments;

use CambioReal\Action\Get;
use CambioReal\Action\Request;
use CambioReal\Config;

class CambioReal
{
    public function __construct()
    {
        Config::set([
            'appId' => env('CAMBIOREAL_APP_ID'),
            'appSecret' => env('CAMBIOREAL_APP_SECRET'),
            'testMode' => env('CAMBIOREAL_TEST_MODE'),
        ]);

    }

    public function request(string $order_id, string $description, float $amount)
    {
        $params = [
            'url_callback' => env('APP_URL') .'/cambioreal/notifications',
            'url_error' => env('APP_URL') .'/cambioreal/error',
            'client' => [
                'name' => 'Fagner',
                'email' => 'fagner.ti@gmail.com',
            ],
            'currency' => 'USD',
            'amount' => $amount,
            'order_id' => $order_id,
            'duplicate' => 0,
            'due_date' => 10,
            'products' => [
                [
                    'descricao' => $description,
                    'base_value' => $amount,
                    'valor' => $amount,
                    'qty' => 1,
                    'ref' => '',
                ],
                /*[
                    'descricao' => 'Frete',
                    'base_value' => 5.0,
                    'valor' => 5.0,
                    'ref' => 'Sao Paulo - SP',
                ]*/
            ],
        ];

        $result = (new Request)->execute($params);


        if ($result->status == 'error') {

            throw new \Exception('Erro ao fazer a requisição de pagamento no Cambio Real: ('. $result->code .') '. $result->message);
        }

        return [
            'gateway' => 'cambioreal',
            'token' => $result->data->token,
            'bill_url' => $result->data->checkout,
            'amount' => $amount,
        ];
    }

    public function response($token)
    {
        $res = (new Get())->execute([
            'token' => $token
        ]);

        logger()->debug('dados de resposta', [
            collect($res)->toArray(),
        ]);

        if ($res->status == 'error') {
            throw new \Exception('Erro ao processar a resposta: ('. $res->code .') '. $res->message);
        }

        return [
            'status' => $res->status,
            'json' => json_encode($res->data),
            'status' => $res->data->status,
            'method' => $res->data->payment_method,
        ];
    }

    public static function getStatus($status): ?int
    {
        switch ($status) {
            case 'BOLETO_GERADO':
                return 0;
            case 'SOLICITACAO_PAGO':
            case 'SOLICITACAO_FINALIZADA':
                return 1;
            case 'BOLETO_EXPIRADO':
            case 'BOLETO_CANCELADO':
            case 'SOLICITACAO_RECUSADA':
            case 'SOLICITACAO_CANCELADA':
            case 'SOLICITACAO_EXPIRADA':
            case 'REFUNDED':
                return 2;
            default:
                return 0;
        }
        return 0;
    }
}
