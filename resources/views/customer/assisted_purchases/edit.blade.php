@extends('layouts.app')

@section('title', 'Editando compra assistida')

@section('breadcrumbs')
    <li><a href="{{ route('packages.index') }}"><span>Compras assistidas</span></a></li>
    <li class="active"><span>Editando compra assistida</span></li>
@endsection

@section("wrapper")
            <!-- Row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card round-10 w-100">
                        <div class="card-header">
                            <h6>Editando compra assistida</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-wrap">
                                <form action="{{ route('customer.assisted-purchases.update', ['assisted_purchase' => $row]) }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    @include('customer.assisted_purchases.form')
                                </form>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Row -->
@endsection
