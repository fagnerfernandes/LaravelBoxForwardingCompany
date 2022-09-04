<?php
namespace App\ExternalApi\Shipping;

class ShippoApi
{
    public function __construct()
    {
        \Shippo::setApiKey(env('SHIPPO_API_TEST'));
    }

    public function teste()
    {
        $address = \Shippo_Address::
        create(
            array(
                 'object_purpose' => 'QUOTE',
                 'name' => 'John Smith',
                 'company' => 'Initech',
                 'street1' => '6512 Greene Rd.',
                 'city' => 'Woodridge',
                 'state' => 'IL',
                 'zip' => '60517',
                 'country' => 'US',
                 'phone' => '773 353 2345',
                 'email' => 'jmercouris@iit.com',
                 'metadata' => 'Customer ID 23424'
            ));
            
        dd($address);
    }
}