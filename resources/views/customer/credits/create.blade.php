@extends('layouts.app')

@section('title', 'Adicionar créditos')

@section('breadcrumbs')
    <li><a href="{{ route('customer.credits.index') }}"><span>Créditos</span></a></li>
    <li class="active"><span>Adicionar créditos</span></li>
@endsection

@section("wrapper")
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class=""> Adicionar créditos</h6>
                </div>
                <div class="card-body">                
                    <div class="form-wrap">
                        <form action="{{ route('customer.credits.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('customer.credits.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection