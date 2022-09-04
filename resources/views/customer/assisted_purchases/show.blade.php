@extends('layouts.app')

@section('title')
    Detalhes da compra assistida
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.assisted-purchases.index') }}"><span>Compras assistidas</span></a></li>
    <li class="active"><span>Compra assistida</span></li>
@endsection

@section("wrapper")
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class="panel-title txt-dark">Detalhes da compra assistida</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    Detalhamento
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Título:</strong> 
                                            <span>{{ $purchase->title }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Link:</strong> 
                                            <a href="{{ $purchase->link }}" target="_blank">
                                                {{ $purchase->link }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Preço:</strong> 
                                            <span>@currency($purchase->price)</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Quantidade:</strong> 
                                            <span>{{ $purchase->quantity }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Cor: </strong> 
                                            <span>{{ $purchase->color ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Segunda opção de cor: </strong> 
                                            <span>{{ $purchase->color_optional ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Tamanho: </strong> 
                                            <span>{{ $purchase->size ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Segunda opção de tamanho: </strong> 
                                            <span>{{ $purchase->size_optional ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Status: </strong> 
                                            <span>{{ $purchase->transaction->status_text ?? $purchase->status_text }}</span>
                                        </div>
                                    </div>
                                    <fieldset>
                                        <title>Observações</title>
                                        {{ $purchase->observations ?? '' }}
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        @if ($purchase->status == 1)
                        <div class="col-md-6">
                            <livewire:payment :withCredits="true" :transaction="$purchase->transaction" :modelClass="App\Models\AssistedPurchase::class" :modelObject="$purchase" :amount="$purchase->price" />
                        </div>
                        @endif
                    </div>
                </div>





                {{-- <div class="card-header">
                    <h6 >Detalhes da compra assistida</h6>
                </div>
                <div class="card-body">
                   
                    <p>
                        
                    </p>
                    <p>
                       
                    </p>
                    <p>
                        
                    </p>
                    <p>
                        
                    </p>
                    <p>
                        
                    </p>
                    <p>
                        
                    </p>
                    <p>
                        
                    </p>
                    <p>
                        
                    </p>
                    <p>
                        <strong>Observações: </strong> {{ $purchase->observations ?? '' }}
                    </p>
                    <p>
                        
                    </p>

                    @if (blank($purchase->transaction) && (int)$purchase->status === 1)
                        <br />
                        <x-paypal-button url="/customer/assisted-purchases/{{ $purchase->id }}/finish/paypal" price="{{ $purchase->price }}"></x-paypal-button>
                        <p class="my-2 text-center">ou</p>
                        <a href="{{ url('customer/assisted-purchases/'. $purchase->id .'/finish/cambioreal') }}" class="d-block btn btn-success btn-lg mt-4" target="_blank">
                            <i class="lni lni-empty-file"></i>
                            Pagar com boleto
                            <small>(Cambio Real)</small>
                        </a>
                    @endif
                </div> --}}
            </div>
        </div>
    </div>

    <style>
        .panel-body p {
            padding: 0.3rem 0;
            border-bottom: 0.08rem solid #eee;
        }
        .panel-body p span {
            display: inline-block;
            width: 25%;
            padding: 0.2rem;
            font-weight: bolder;
        }
        .panel-body p span:after {
            content: ": ";
        }
    </style>
@endsection
