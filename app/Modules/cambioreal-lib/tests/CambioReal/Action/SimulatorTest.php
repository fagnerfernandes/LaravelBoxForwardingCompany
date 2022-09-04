<?php

/**
 * The simulator action class
 *
 * @author Deivide Vian <dvdvian@gmail.com>
 */
class SimulatorTest extends TestCase {

    public function testValidateCurrency()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'currency' was not supplied.");
        \CambioReal\CambioReal::simulator(array());
    }

    public function testValidateAmount()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'amount' was not supplied.");
        \CambioReal\CambioReal::simulator(array('currency' => 'USD'));
    }

    public function testSimulatorRequestIsCorrect()
    {
        $request = \CambioReal\CambioReal::simulator(array(
			'currency'       => 'USD',
			'amount'         => 50.00,
			'take_rates'     => false,
			'payment_method' => 'boleto',
        ));

        $this->assertEquals('POST', $request['method']);
        $this->assertEquals('http://cambiorealdev.dev/service/v1/checkout/simulator', $request['action']);
        $this->assertEquals(true, $request['decode'], true);
    }

}
