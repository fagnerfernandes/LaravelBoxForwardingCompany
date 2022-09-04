<?php

require_once 'bootstrap.php';

/**
 * Request para criar a cobrança na CambioReal.
 */
$request = \CambioReal\CambioReal::request(array(
    'client' => array(
        'name'  => 'John Test',
        'email' => 'john@test.com',
    ),
    'currency'  => 'USD',
    'amount'    => 130.00,
    'order_id'  => '10000052',
    'duplicate' => false,
    'due_date'  => null,
    'products'  => array(
        array(
            'descricao'  => 'Laptop i7',
            'base_value' => 800.00,
            'valor'      => 1600.00,
            'qty'        => 2,
            'ref'        => 1,
        ),
        array(
            'descricao'  => 'Frete',
            'base_value' => 5.00,
            'valor'      => 5.00,
            'ref'        => 'São Paulo - SP',
        ),
    ),
));

/**
 * Request para cancelar a cobrança anteriormente criada.
 */
$response = \CambioReal\CambioReal::cancel(array(
	'id'    => $request->data->id,
	'token' => $request->data->token
));

var_dump($response);