@extends('layouts.app')

@section('title', 'Criando Template de E-mail')

@section('breadcrumbs')
    <li><a href="{{ route('mail_templates.index') }}"><span>Lista de Templates de E-mail</span></a></li>
    <li class="active"><span>Criando Template de E-mail</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-store"></i> Criando Template de E-mail</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <livewire:mail-template />
                            {{-- <form action="{{ route('mail_templates.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include ('mail_templates.form')
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection


