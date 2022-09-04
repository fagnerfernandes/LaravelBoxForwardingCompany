<div>
    @switch($purchase->purchase_status_id)
        @case(App\Enums\PurchaseStatusEnum::WAITING_APPROVAL)
            <div class="card">
                <div class="card-header">
                    Aguardando pagamento
                </div>
                <div class="card-body">
                    <a id="btnCambioReal" class="d-block btn btn-success btn-lg w-100" href="{{ $purchase->paymentCambioReal->transaction->bill_url }}" target="_blank">
                            <i class="lni lni-empty-file"></i>
                        Acessar link de pagamento
                    </a>
                </div>
            </div>
    
        {{-- <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center p-2">
                    <i class="bx bx-error-circle" style=" font-size: 128px" data-width="128" data-height="128"></i>
                    <h4 class="text-white mt-2">Aguardando confirmação de pagamento!</h4>
                </div>
            </div>
        </div> --}}
        @break

        @case(App\Enums\PurchaseStatusEnum::PAYED)
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center p-2">
                    <i class="bx bx-check-circle" style=" font-size: 128px" data-width="128" data-height="128"></i>
                    <h4 class="text-white mt-2">Pagamento já efetuado!</h4>
                </div>
            </div>
        </div>
        @break

        @default
            <div class="row">
                <div class="col">
                    <div class="card mb-0">
                        <div class="card-header">
                            Formas de Pagamento
                        </div>
                        <div class="card-body">

                            @if ($withCredits)
                                @if ($useCredits)
                                    @if ($appliedCredits)
                                        <div class="row form-group animate__animated animate__fadeIn">
                                            <div class="col-md-8">
                                                <div class="d-flex justify-content-between px-2">
                                                    <strong>Montante Pago com Créditos:</strong>
                                                    <span>@currency($creditUsed)</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between bg-light py-2 px-2">
                                                    <strong>Saldo Restante:</strong>
                                                    <strong>@currency($amount - $creditUsed)</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex justify-content-end align-items-start">
                                                <button class="btn btn-danger" wire:click.prevent="cancelCredits">Cancelar</button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row form-group animate__animated animate__fadeIn">
                                            <div class="col-md-4">
                                                <label for="totalUsedCredits">Usar meus Créditos</label>
                                                <input type="number" name="totalUsedCredits" pattern="^\d+(\.)\d{2}$" id="totalUsedCredits" min="0.00" max={{ $this->creditAvailable >= $this->amount ? $this->amount : $this->creditAvailable }}" step="0.01" class="form-control" wire:model="creditUsed">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="d-flex justify-content-between">
                                                    <span class="bedge p-2 mt-4 ml-2">0</span>
                                                    <input type="range" value="0.00" class="form-range mt-4 pt-3" min="0.00" max="{{ $this->creditAvailable >= $this->amount ? $this->amount : $this->creditAvailable }}" step="0.01" id="customRange3" wire:model="creditUsed"> 
                                                    <span class="bedge p-2 mt-4 mr-1">{{ $this->creditUsed }}/{{ ($this->creditAvailable >= $this->amount) ? $this->amount : $this->creditAvailable }}</span>     
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group mt-3 animate__animated animate__fadeIn">
                                            <div class="col-md-6">
                                                <button class="btn btn-danger w-100" wire:click.prevent="activeCredits(false)">Cancelar</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalAlertPaymentMethods">Confirmar</button>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <button class="btn btn-primary w-100 btn-lg animate__animated animate__fadeIn" wire:click.prevent="activeCredits(true)">Usar meus Créditos (Disponível: @currency($this->creditAvailable))</button>
                                @endif
                                <hr>
                                @if ($this->appliedCredits && ($amount - $creditUsed == 0)) 
                                    <button class="btn btn-success w-100" wire:click.prevent="finishWithCredits">Concluir com Créditos</button>
                                @endif
                            @endif
                            <div id="payment-gateways" style="{{ !$showPaymentGateways ? 'display: none' : '' }}" class="animate__animated animate__fadeIn">
                                <input type="hidden" id="totalWithCredits" value="{{ (float)$this->amount - (float)$this->creditUsed }}">
                                <x-paypal-button url="{{ $this->urlPaypal }}" amountToPay="totalWithCredits"></x-paypal-button>
                                <hr>
                                <x-cambio-real-button url="{{ $this->urlCambioReal }}" parent="payment-gateways" price="{{ (float)$this->amount - (float)$this->creditUsed }}"></x-cambio-real-button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endswitch
    <div class="modal fade show" id="modalAlertPaymentMethods" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atenção</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        O saldo restante após a aplicação dos Créditos, deverá ser pago com uma das formas de pagamento disponíveis.
                    </p>
                    <p>
                        Não é possível dividir o saldo restante entre formas de pagamentos diferentes, <strong>Atenção ao selecionar a forma de pagamento desejada!</strong>
                    </p>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" wire:click.prevent="applyCredits" data-bs-dismiss="modal">Aceitar e continuar</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
