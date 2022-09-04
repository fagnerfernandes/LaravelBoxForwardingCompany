@extends('layouts.app')

@section('title', 'Nova compra assistida')

@section('breadcrumbs')
    <li><a href="{{ route('customer.assisted-purchases.index') }}"><span>Compras assistida</span></a></li>
    <li class="active"><span>Nova compra assistida</span></li>
@endsection

@section("wrapper")
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 >Nova compra assistida</h6>
                </div>
                <div class="card-body">
                    <div class="">
                        <div class="form-wrap">
                            <form action="{{ route('customer.assisted-purchases.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('customer.assisted_purchases.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
