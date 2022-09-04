<?php

namespace App\ExternalApi\Payments;

use Illuminate\Database\Eloquent\Model;

class Blacktag
{
    private $endpoint = 'https://api.pagar.me/1';

    private $gateway;

    private $customer;

    public $items = [];

    public $total_price = 0;

    private $apikey = "ak_test_XUhXf1xl4enIg0lb6DWSuRq4lkPf7d";

    public function __construct()
    {
        $this->gateway = new Client($this->apikey);
    }

    public function createCustomer(Model $customer)
    {
        $this->customer = $this->pagarme->customers()->create([
            'external_id' => (string)$customer->id,
            'name' => $customer->name,
            'type' => 'individual',
            'country' => 'br',
            'email' => $customer->email,
            'documents' => [
                [
                    'type' => 'cpf',
                    'number' => $customer->document,
                ]
            ],
            'phone_numbers' => [
                // '55'. str_replace(['(', ')', '-', ' '], '', $customer->phone),
                '+55 11969159344'
            ],
            'birthday' => '1987-03-04',
        ]);

        return $this;
    }

    public function addItem($name, $price, $quantity)
    {
        $this->items[] = [
            'id' => (count($this->items) + 1),
            'title' => $name,
            'unit_price' => $price,
            'quantity' => $quantity,
            'tangible' => false,
        ];

        $this->sumItems();

        return $this;
    }

    public function sumItems()
    {
        $this->total_price = collect($this->items)->sum(function($item) {
            return $item['unit_price'] * $item['quantity'];
        });
    }

    public function createTransaction($payment_method)
    {
        $data = [
            'amount' => $this->total_price,
            'payment_method' => $payment_method,
            'customer' => $this->customer,
            'billing' => [
                'name' => '',
                'address' => [
                    'country' => 'br',
                    'street' => '',
                    'street_number' => '',
                    'state' => '',
                    'city' => '',
                    'neighborhood' => '',
                    'zipcode' => '',
                ],
            ],
            'items' => $this->items,
        ];

        if ($payment_method == 'credit_card') {
            // se cartao de credito
            $data += [
                'card_holder_name' => '',
                'card_cvv' => '',
                'card_number' => '',
                'card_expiration_date' => '',
            ];
        } else if ($payment_method == 'boleto') {
            $data += [
                ''
            ];
        }

        dd($data);
        //$transaction = $this->pagarme->transactions()->create($data);
    }

}
