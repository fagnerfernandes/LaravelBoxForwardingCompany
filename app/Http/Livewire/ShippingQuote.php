<?php

namespace App\Http\Livewire;

use App\ExternalApi\Shipping\Skypostal;
use App\Models\Setting;
use Livewire\Component;

class ShippingQuote extends Component
{
    public $quotes = [];
    public $weight = 0;
    public $unit = 'LB';

    public function render()
    {
        return view('livewire.shipping-quote');
    }

    public function mount() {
        if ($this->weight) {
            $this->getQuotes($this->weight, $this->unit);
        }
    }

    public $listeners = ['getQuote' => 'getQuotes'];

    public function getQuotes($weight, $unit = 'KG') {
        $this->quotes = [];

        $skyPostal = new Skypostal($weight, 0, $unit);
        $quote301 = $skyPostal->requestQuote();

        if ($quote301) {
            $this->quotes[] = [
                'type' => 'Packet Standard',
                'value' => $this->getValueWithFee(floatval($quote301->data[0]->total_value))
            ];
        }
        $skyPostal->serviceCode = 302; 
        $quote302 = $skyPostal->requestQuote();
        if ($quote302) {
            $this->quotes[] = [
                'type' => 'Packet Express',
                'value' => $this->getValueWithFee(floatval($quote302->data[0]->total_value))
            ];
        }
    }

    private function getValueWithFee(float $value) {
        $fee = Setting::where('key', 'adicional.frete')->first();
        if ($fee) {
            $feeValue = $value * (floatval($fee->value) / 100);
            return $value + $feeValue;
        } else {
            return $value;
        }
    }
}
