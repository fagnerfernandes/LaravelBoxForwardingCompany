@extends('layouts.app')

@section('title')
    Alterando Senha de Cliente
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customers.index') }}"><span>Clientes</span></a></li>
    <li class="active"><span>Alterando Senha de cliente</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-account"></i> Alterando Senha de cliente</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('customers.password.update', ['customer' => $customer]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="user.name" class="control-label">Nome</label>
                                        <div class="form-control bg-light">{{ $customer->user->name }}</div>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="user.name" class="control-label">E-mail</label>
                                        <div class="form-control bg-light">{{ $customer->user->email }}</div>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="user.name" class="control-label">CPF</label>
                                        <div class="form-control bg-light">{{ $customer->document }}</div>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="user.name" class="control-label">Suite</label>
                                        <div class="form-control bg-light">{{ $customer->suite }}</div>
                                    </div>
                                
                                    <div class=" col-md-4 form-group mb-3 {{ $errors->has('password') ? 'has-error' : ''}}">
                                        <label for="password" class="control-label">{{ 'Senha' }}</label>
                                        <input class="form-control" name="user[password]" type="password" id="password" value="" >
                                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                    </div>
                                
                                    <div class=" col-md-4 form-group mb-3 {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                                        <label for="password_confirmation" class="control-label">{{ 'Confirmação da senha' }}</label>
                                        <input class="form-control" name="user[password_confirmation]" type="password" id="password_confirmation" value="" >
                                        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <hr />
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ URL::previous() }}" class="btn btn-light">
                                        voltar
                                    </a>
                                
                                    <button type="submit" class="btn btn-success">
                                        <span class="btn-text">Gravar</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
