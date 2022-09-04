@extends('layouts.app')

@section('title', 'Novo usuário')

@section('breadcrumbs')
    <li><a href="{{ route('users.index') }}"><span>Usuários</span></a></li>
    <li class="active"><span>Novo usuário</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-body">
                    <h6>Novo usuário</h6>
                    
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf
                                @include('users.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection