@extends('layouts.app')

@section('title', 'Trocar senha')

@section('breadcrumbs')
    <li class="active"><span>trocar senha</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Trocar senha</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('change-password.update') }}" method="POST" enctype="multipart/form-data">
                                @method('POST')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label mb-10 text-left" for="password">Nova senha</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Informe a nova senha" value="" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label mb-10 text-left" for="password_confirmation">Confirmar nova senha</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirme a nova senha" value="" />
                                    </div>
                                </div>
                                
                                {{-- <hr /> --}}
                                <button type="submit" class="btn btn-success">
                                    <span class="btn-text">Gravar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection