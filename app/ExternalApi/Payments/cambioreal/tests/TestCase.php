<?php
namespace App\ExternalApi\Payments\cambioreal\tests;
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
			'appId' => env('CAMBIOREAL_APP_ID'),
            'appSecret' => env('CAMBIOREAL_APP_SECRET'),
			'httpRequest' => '\\Mock\\Http\\Request',
			'testMode'    => true,
        ));
    }

}
