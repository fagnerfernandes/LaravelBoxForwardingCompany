@extends('layouts.app')

@section('title', 'Criando Onde Comprar')

@section('breadcrumbs')
    <li><a href="{{ route('shops.index') }}"><span>Lista de onde comprar</span></a></li>
    <li class="active"><span>Criando onde comprar</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-store"></i> Criando onde comprar</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ url('/shops') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include ('shops.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
