@extends('layouts.app')

@section('title', 'Editando pacote')

@section('breadcrumbs')
    <li><a href="{{ route('packages.index') }}"><span>Pacotes</span></a></li>
    <li class="active"><span>Editando pacote</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card roud-10 w-100">
                <div class="card-body">
                    <h6 class="panel-title txt-dark">Editando pacote</h6>
                    
                    <div class="form-wrap">
                        <form action="{{ route('packages.update', ['package' => $row]) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
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