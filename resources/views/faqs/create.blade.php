@extends('layouts.app')

@section('title', 'Novo FAQ')

@section('breadcrumbs')
    <li><a href="{{ route('faqs.index') }}"><span>FAQs</span></a></li>
    <li class="active"><span>Novo FAQ</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h2 class="panel-title txt-dark"><i class="zmdi zmdi-comments"></i> Novo FAQ</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('faqs.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('faqs.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection
