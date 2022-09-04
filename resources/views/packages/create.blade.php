@extends('layouts.app')

@section('title', 'Novo pacote')

@section('breadcrumbs')
    <li><a href="{{ route('packages.index') }}"><span>Pacotes</span></a></li>
    <li class="active"><span>Novo pacote</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card roud-10 w-100">
                <div class="card-body">
                    <h6 class="panel-title txt-dark">Novo pacote</h6>
                
                    <div class="form-wrap">
                        <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('packages.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection