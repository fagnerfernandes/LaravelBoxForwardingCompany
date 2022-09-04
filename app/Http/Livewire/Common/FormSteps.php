<?php

namespace App\Http\Livewire\Common;

use Livewire\Component;

class FormSteps extends Component
{
    public $steps = 0;
    public $currentStep = 1;

    public function render()
    {
        return view('livewire.common.form-steps');
    }

    public function setCurrentStep($currentStep) {
        $this->currentStep = $currentStep;

        $this->emit('stepChanged', $this->currentStep);
    } 
}
