<?php

require_once 'Mock/Http/Request.php';

/**
 * Test Case
 *
 * @author Deivide Vian <dvdvian@gmail.com>
 */
class TestCase extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        \CambioReal\Config::set(array(
			'appId'       => '1664250130',
			'appSecret'   => '$2y$10$nU.tUrnhdxC56F1uXlrbp.SmzUAtdQ/7v29WMqDeaFFZN8mMi3.Ra',
			'httpRequest' => '\\Mock\\Http\\Request',
			'testMode'    => true,
        ));
    }
    
}
