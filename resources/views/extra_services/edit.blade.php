@extends('layouts.app')

@section('title', 'Editando serviço extra')

@section('breadcrumbs')
    <li><a href="{{ route('faqs.index') }}"><span>Serviços extras</span></a></li>
    <li class="active"><span>Editando serviço extra</span></li>
@endsection

@section("wrapper")
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-body">
                    
                    <h6 class="panel-title txt-dark"><i class="zmdi zmdi-widgets"></i> Editando serviço extra</h6>
            
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('extra-services.update', ['extra_service' => $extra_service]) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
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
