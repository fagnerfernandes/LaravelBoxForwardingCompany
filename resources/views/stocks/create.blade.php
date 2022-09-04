@extends('layouts.app')

@section('title', 'Nova movimentação de estoque')

@section('breadcrumbs')
    <li><a href="{{ route('stocks.index') }}"><span>Movimentações de estoque</span></a></li>
    <li class="active"><span>Nova movimentação de estoque</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h2 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Nova movimentação de estoque</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('stocks.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('stocks.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
