@extends('layouts.app')

@section('title')
    Detalhes do créditos
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.credits.index') }}"><span>Créditos</span></a></li>
    <li class="active"><span>Detalhes do crédito</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class="panel-title txt-dark">Detalhes dos créditos</h6>
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
                                            <strong>Data da operação</strong>
                                            <span>{{ $credit->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Descrição</strong>
                                            <span>{{ $credit->description }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Tipo de movimentação</strong>
                                            <span>{{ ($credit->type == 'out') ? 'Saída' : 'Entrada' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col d-flex justify-content-between mb-3">
                                            <strong>Valor do crédito</strong>
                                            <span>{{ $credit->amount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($credit->is_buying)
                        <div class="col-md-6">
                            <livewire:payment :withCredits="false" :transaction="$credit->transaction" :modelClass="App\Models\Credit::class" :modelObject="$credit" :amount="$credit->amount" />
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
@endsection