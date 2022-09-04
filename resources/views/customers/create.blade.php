@extends('layouts.app')

@section('title', 'Criando cliente')

@section('breadcrumbs')
    <li><a href="{{ route('customers.index') }}"><span>Clientes</span></a></li>
    <li class="active"><span>Criando cliente</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-account"></i> Criando cliente</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include ('customers.form', ['editing' => false])
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
