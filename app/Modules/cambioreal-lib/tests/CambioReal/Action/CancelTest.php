<?php

/**
 * The cancel action class
 *
 * @author Deivide Vian <dvdvian@gmail.com>
 */
class CancelTest extends TestCase {

    public function testValidateId()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'id' was not supplied.");
        \CambioReal\CambioReal::cancel(array());
    }

    public function testValidateToken()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'token' was not supplied.");
        \CambioReal\CambioReal::cancel(array('id' => '123213'));
    }

    public function testCancelRequestIsCorrect()
    {
        $id = 123123123;
        $token = md5(time());
        $request = \CambioReal\CambioReal::cancel(array('id' => $id, 'token' => $token));

        $this->assertEquals('POST', $request['method']);
        $this->assertEquals('http://cambiorealdev.dev/service/v1/checkout/cancel', $request['action']);
        $this->assertEquals(true, $request['decode'], true);
        $this->assertEquals($id, $request['params']['id'], $id);
        $this->assertEquals($token, $request['params']['token'], $token);
    }

}
