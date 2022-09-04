<?php

/**
 * CambioReal class tests
 *
 * @author Deivide Vian <dvdvian@gmail.com>
 */
class CambioRealTest extends TestCase {

    public function testCallInvalidAction()
    {
        $this->setExpectedException('RuntimeException', "Action 'starWars' doesn't exist.");
        \CambioReal\CambioReal::starWars('teste');
    }

    public function testCallActionWithoutArguments()
    {
        $this->setExpectedException('InvalidArgumentException', 'The action call received no arguments.');
        \CambioReal\CambioReal::request();
    }
    
}
