@extends('layouts.app')

@section('title', 'Editando tipo de declaraçao')

@section('breadcrumbs')
    <li><a href="{{ route('declaration_types.index') }}"><span>Tipos de declaração</span></a></li>
    <li class="active"><span>Editando tipo de declaração</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Editando tipo de declaração</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('declaration_types.update', ['declaration_type' => $declaration_type]) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                @include('declaration_types.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
