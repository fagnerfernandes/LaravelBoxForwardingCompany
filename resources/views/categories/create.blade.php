@extends('layouts.app')

@section('title', 'Nova categoria')

@section('breadcrumbs')
    <li><a href="{{ route('categories.index') }}"><span>Categorias</span></a></li>
    <li class="active"><span>Nova categoria</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Nova categoria</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('categories.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
