@extends('layouts.app')

@section('title', 'Editando produto')

@section('breadcrumbs')
    <li><a href="{{ route('products.index') }}"><span>Produtos</span></a></li>
    <li class="active"><span>Editando produto</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Editando produto</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('products.update', ['product' => $product]) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                @include('products.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
