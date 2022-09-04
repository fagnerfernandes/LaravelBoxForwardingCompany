@extends('layouts.app')

@section('title')
    Afiliados
@endsection

@section('breadcrumbs')
    <li class="active"><span>Afiliados</span></li>
@endsection

@section('wrapper')
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h4 class="panel-title txt-dark"><i class="zmdi zmdi-store"></i> Afiliados</h4>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-primary" style="height: 110px;">
                                    <div class="card-header">
                                        <i class="zmdi zmdi-share zmdi-hc-1x"></i> Compartilhe
                                    </div>
                                    <div class="panel-body text-center" style="padding: 1rem;">
                                        <a href="#" style="margin: 0 1rem">
                                            <i class="zmdi zmdi-email-open zmdi-hc-2x"></i>
                                        </a>
                                        <a href="#" style="margin: 0 1rem">
                                            <i class="zmdi zmdi-facebook-box zmdi-hc-2x"></i>
                                        </a>
                                        <a href="#" style="margin: 0 1rem">
                                            <i class="zmdi zmdi-instagram zmdi-hc-2x"></i>
                                        </a>
                                        <a href="#" style="margin: 0 1rem">
                                            <i class="zmdi zmdi-twitter-box zmdi-hc-2x"></i>
                                        </a>
                                        <a href="#" style="margin: 0 1rem">
                                            <i class="zmdi zmdi-whatsapp zmdi-hc-2x"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="panel panel-danger" style="height: 110px;">
                                    <div class="card-header" style="color: white">
                                        <i class="zmdi zmdi-mail-send zmdi-hc-1x"></i> 
                                        Afiliado: 
                                        {{ auth()->user()->userable->afilliate_token }}
                                    </div>
                                    <div class="panel-body" style="padding: 1rem;">
                                        <p>
                                            Informe seu link e receba créditos toda vez que um indicado seu usar nossos serviços
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-default" style="height: 120px;">
                                    <div class="panel-body text-white">
                                        <h6 class="lead text-center">Total de indicações</h6>
                                        <p class="h2 text-center">{{ $indicates }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default" style="height: 120px;">
                                    <div class="panel-body text-white">
                                        <h6 class="lead text-center">Saldo atual</h6>
                                        <p class="h5 text-center">
                                            Para utilizar seu saldo atual, entre em contato com noreply@company.com
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
@endsection
