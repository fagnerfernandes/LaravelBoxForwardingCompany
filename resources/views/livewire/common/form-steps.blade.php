<div class="d-flex justify-content-center align-items-center">
    @for ($step = 1; $step <= $steps; $step++) 
    <button type="button" class="translate-middle btn btn-sm {{ $currentStep >= $step ? 'btn-primary' : 'btn-secondary' }} rounded-pill mx-4" style="width: 2rem; height:2rem;" wire:click.prevent="setCurrentStep({{ $step }})">{{ $step }}</button>  
    @endfor
</div>
