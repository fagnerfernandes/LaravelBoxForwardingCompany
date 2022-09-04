@extends('layouts.app')

@section('title', 'Editando endereço')

@section('breadcrumbs')
    <li><a href="{{ route('customer.credits.index') }}"><span>Créditos</span></a></li>
    <li class="active"><span>Editando crédito</span></li>
@endsection

@section("wrapper")
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class="">Editando endereço</h6>
                </div>
                <div class="card-body">
                    <div class="form-wrap">
                        <form action="{{ route('customer.addresses.update', ['address' => $row]) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            @include('addresses.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection