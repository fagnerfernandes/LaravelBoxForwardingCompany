@extends('layouts.app')

@section('title', 'Novo serviço extra')

@section('breadcrumbs')
    <li><a href="{{ route('extra-services.index') }}"><span>Serviços extras</span></a></li>
    <li class="active"><span>Novo serviço extra</span></li>
@endsection

@section("wrapper")
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-body">
                    <h6>Novo serviço extra</h6>
                    
                    <div class="form-wrap">
                        <form action="{{ route('extra-services.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('extra_services.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
