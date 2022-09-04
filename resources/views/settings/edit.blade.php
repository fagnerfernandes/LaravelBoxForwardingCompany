@extends('layouts.app')

@section('title', 'Editando configuração')

@section('breadcrumbs')
    <li><a href="{{ route('settings.index') }}"><span>Configurações</span></a></li>
    <li class="active"><span>Editando configuração</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Editando configuração</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('settings.update', ['setting' => $setting]) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                @include('settings.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
