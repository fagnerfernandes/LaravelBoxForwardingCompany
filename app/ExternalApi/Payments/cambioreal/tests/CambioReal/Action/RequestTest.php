<?php

/**
 * Request action for api
 *
 * @author Deivide Vian <dvdvian@gmail.com>
 */
class RequestTest extends TestCase {

    protected $params;

    public function setUp()
    {
        parent::setUp();

        $this->params = array(
            'client' => array(
                'name'  => 'John Maxxel',
                'email' => 'john@max.com',
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
        );
    }

    public function testValidateCurrencyCode()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'currency' was not supplied.");
        unset($this->params['currency']);
        \CambioReal\CambioReal::request($this->params);
    }

    public function testValidateAmount()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'amount' was not supplied.");
        unset($this->params['amount']);
        \CambioReal\CambioReal::request($this->params);
    }

    public function testValidateClientName()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'client.name' was not supplied.");
        unset($this->params['client']['name']);
        \CambioReal\CambioReal::request($this->params);
    }

    public function testValidateClientEmail()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'client.email' was not supplied.");
        unset($this->params['client']['email']);
        \CambioReal\CambioReal::request($this->params);
    }

    public function testValidateOrderId()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'order_id' was not supplied.");
        unset($this->params['order_id']);
        \CambioReal\CambioReal::request($this->params);
    }

    public function testValidateProducts()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'products' was not supplied.");
        unset($this->params['products']);
        \CambioReal\CambioReal::request($this->params);
    }

    public function testRequestIsCorrect()
    {
        $request = \CambioReal\CambioReal::request($this->params);

        $this->assertEquals('POST', $request['method']);
        $this->assertEquals('http://cambiorealdev.dev/service/v1/checkout/request', $request['action']);
        $this->assertEquals(true, $request['decode'], true);
        $this->assertEquals($this->params['amount'], $request['params']['amount']);
        $this->assertEquals($this->params['currency'], $request['params']['currency']);
        $this->assertEquals($this->params['client']['name'], $request['params']['client']['name']);
        $this->assertEquals($this->params['client']['email'], $request['params']['client']['email']);
        $this->assertEquals($this->params['products'], $request['params']['products']);
    }

}
