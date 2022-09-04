@extends('layouts.app')

@section('title', 'Editando endereço')

@section('breadcrumbs')
    <li><a href="{{ route('customer.addresses.index') }}"><span>Endereços</span></a></li>
    <li class="active"><span>Editando endereço</span></li>
@endsection

@section("wrapper")
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-item-center">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-pin"></i> Editando endereço</h6>
                    </div>
                </div>
                <div class="card-body"> 
                    <form action="{{ route('customer.addresses.update', ['address' => $row]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('customer.addresses.form')
                    </form>
                
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection