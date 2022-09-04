@extends('layouts.app')

@section('title', 'Novo serviço premium')

@section('breadcrumbs')
    <li><a href="{{ route('premium_services.index') }}"><span>Serviços premium</span></a></li>
    <li class="active"><span>Novo serviço premium</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h2 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Novo serviço premium</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('premium_services.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('premium_services.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
