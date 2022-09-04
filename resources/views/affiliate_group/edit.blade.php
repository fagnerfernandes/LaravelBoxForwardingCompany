@extends('layouts.app')

@section('title', 'Criando Grupo de Afiliados')

@section('breadcrumbs')
    <li><a href="{{ route('customers.index') }}"><span>Grupo de Afiliados</span></a></li>
    <li class="active"><span>Criando Grupo de Afiliados</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-account"></i> Criando Grupo de Afiliados</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <livewire:affiliate-group-component :affiliateGroup="$affiliateGroup"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection