<?php

namespace App\ExternalApi\Payments;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Sample\PayPalClient;

class Paypal
{
    public function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    public static function environment()
    {
        $clientId = env('PAYPAL_ID');
        $clientSecret = env('PAYPAL_SECRET');

        if (config('app.env', 'local') == 'production') {
            return new ProductionEnvironment($clientId, $clientSecret);
        } else {
            return new SandboxEnvironment($clientId, $clientSecret);
        }
        
    }

    public function getOrder($orderId)
    {
        $client = $this->client();

        $response = $client->execute(new OrdersGetRequest($orderId));

        // transaction details
        $orderID = $response->result->id;
        $email = $response->result->payer->email_address;
        //$status = $response->result->purchase_units[0]->payments->captures[0]->status;
        $status = $response->result->status;
        $transactionID = $response->result->purchase_units[0]->payments->captures[0]->id;
        $amount = $response->result->purchase_units[0]->amount->value;

        return [
            'gateway' => 'paypal',
            'orderID' => $orderID,
            'transactionID' => $transactionID,
            'status' => $status,
            'amount' => $amount,
        ];
    }

    public static function getStatus($status): ?int
    {
        switch ($status) {
            case 'COMPLETED':
                return 1;
            default:
                return 0;
        }
    }
}
