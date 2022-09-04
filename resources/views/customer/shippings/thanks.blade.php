@extends('layouts.app')

@section('title')
    Solicitação de envio finalizada
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.shippings.index') }}">Meus envios</a></li>
    <li class="active"><span>Solicitação de envio finalizada</span></li>
@endsection

@section('wrapper')
    
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h4 class="mb-40 panel-title txt-dark"><i class="zmdi zmdi-airplane"></i> Solicitação de envio finalizada</h4>
                </div>
                <div class="card-body">
                    <p class="text-center pb-20">
                        <img src="{{ asset('img/check.png') }}" width="100" alt="Solicitação finalizada com sucesso!" />
                    </p>
                    <p class="lead text-center pb-40">Parabéns, sua solicitação foi concluída com sucesso!</p>
                </div>
            </div>
        </div>
    </div>
@endsection