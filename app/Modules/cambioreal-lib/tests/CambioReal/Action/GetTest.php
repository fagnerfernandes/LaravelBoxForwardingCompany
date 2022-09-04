<?php

class GetTest extends TestCase {

    public function testValidateIdRequired()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'id' was not supplied.");
        \CambioReal\CambioReal::get(array());
    }

    public function testValidateTokenRequired()
    {
        $this->setExpectedException('InvalidArgumentException', "The parameter 'token' was not supplied.");
        \CambioReal\CambioReal::get(array('id' => 123123));
    }

    public function testRequest()
    {
        $id = 1312323;
        $token = md5(time());
        $request = \CambioReal\CambioReal::get(array('id' => $id, 'token' => $token));

        $this->assertEquals('GET', $request['method']);
        $this->assertEquals('http://cambiorealdev.dev/service/v1/checkout/get', $request['action']);
        $this->assertEquals(true, $request['decode']);
        $this->assertEquals($id, $request['params']['id']);
        $this->assertEquals($token, $request['params']['token']);
    }

}
