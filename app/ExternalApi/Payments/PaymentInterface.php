<?php
namespace App\ExternalApi\Payments;

interface PaymentInterface
{
    public function setPayer($user): void;

    public function addItem($description, $qtd, $price): void;

    public function createToken($holder_name, $number, $cvv, $expiration): string;

    public function createInvoice($payment_form, $due_date);

    public function creditCardPayment($order_id, $token, $installments): ?array;

    public function boletoPayment($order_id, $installments): ?array;

    public function plan($identifier, $months, $value_total);

    public function subscribe($identifier, $token);
}
