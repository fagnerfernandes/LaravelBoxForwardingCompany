<div>
    <div class="row" >
        <img src="{{ asset('img/spin.gif') }}" alt="loading" class="mx-auto" style="width: 140px" wire:loading.delay.short />   
    </div>
    <div class="row" wire:loading.remove.delay.short>
        @foreach ($quotes as $quote)
            <div class="col-6">
                <div class="card card-item panel-default mb-0">
                    <!-- Default panel contents -->
    
                    <div class=" card-body"="">
            
                        <p class="lead text-center">@currency($quote['value'])</p>
                        <p class="text-center">
            
                            <input type="hidden" name="shipping_estimate" value="30">
                            <em>Nome: {{ $quote['type'] }}</em>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
