<?php
namespace App\Traits;

use App\Constants\EmailVariables;
use App\Models\Address;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Arr;

class teste {
    use EmailVariablesTrait;

    public function teste() {
       /*  $data = Arr::dot(Address::first()->toArray());
        foreach ($this->getData(EmailVariables::ADDRESS, $data) as $key => $value) {
            print_r($key.' => '.$value.'\n');
        } */
        //return $this->getAddressData(Address::first());

        /* foreach ($this->getAddressData(Address::first()) as $key => $value) {
            print_r($key.' => '.$value.'\n');
        } */

        return $this->getPurchaseData(Purchase::find(31));
    }
}