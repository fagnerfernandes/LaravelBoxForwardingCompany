<?php

namespace App\Http\Livewire;

use App\ExternalApi\Shipping\Skypostal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ShippingCalc extends Component
{
    public $unit = 'KG';
    public $weight = 0;

    public function render()
    {
        return view('livewire.shipping-calc');
    }

    public function updated() {
        if ($this->weight) {
            $this->emit('getQuote', $this->weight, $this->unit);
        }
    }    
}
