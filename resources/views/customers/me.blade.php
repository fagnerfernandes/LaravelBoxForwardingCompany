@extends('layouts.app')

@section('title', 'Meus dados')

@section('breadcrumbs')
    <li class="active"><span>Meus dados</span></li>
@endsection

@section('wrapper')
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Meus dados</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('customer.me.update') }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-3">
                                                <label class="control-label mb-10 text-left" for="user_name">Nome</label>
                                                <input type="text" class="form-control" name="user[name]" id="user_name" placeholder="Seu nome" value="{{ !empty($customer->user->name) ? $customer->user->name : old('user.name') }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-3">
                                                <label class="control-label mb-10 text-left" for="user_phone_number">Telefone</label>
                                                <input type="text" class="form-control" name="user[phone_number]" id="user_phone_number" placeholder="Seu Telefone" value="{{ !empty($customer->user->phone_number) ? $customer->user->phone_number : old('user.phone_number') }}" />
                                            </div>
                                            <div class="form-group col-md-6 mb-3">
                                                <label class="control-label mb-10 text-left" for="user_email">Email</label>
                                                <input type="email" class="form-control" name="user[email]" id="user_email" placeholder="Seu email" value="{{ !empty($customer->user->email) ? $customer->user->email : old('user.email') }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-3">
                                                <label class="control-label mb-10 text-left" for="document">CPF/CNPJ</label>
                                                <input type="text" class="form-control" name="document" id="document" placeholder="Seu CPF/CNPJ" value="{{ !empty($customer->document) ? $customer->document : old('document') }}" />
                                            </div>
                                            <div class="form-group col-md-6 mb-3">
                                                <label class="control-label mb-10 text-left" for="suite">Suite</label>
                                                <input type="text" class="form-control" disabled id="suite" placeholder="Sua Suite" value="{{ $customer->suite }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card" style="height: 100%">
                                            <div class="card-body d-flex justify-content-center align-items-center">
                                                <a href="" title="Alterar Imagem de Perfil" id="img_avatar">
                                                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('img/me.png') }}" alt="Foto de Perfil" class="rounded-circle p-1 bg-primary img-fluid img-thumbnail" style="width: 128px; height: 128px; object-fit: cover">
                                                </a>
                                            </div>
                                            <div class="card-footer" style="display: none" id="feedback_avatar">
                                                <p>Imagem de Perfil alterada, clique em Gravar para confirmar!</p>
                                            </div>
                                            <input type="file" name="user[avatar]" id="avatar" style="display: none">
                                        </div>
                                    </div>

                                </div>

                                <fieldset class="mt-5">
                                    <legend>
                                        <h4 class="mb-3">Trocar senha</h4>
                                    </legend>
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label class="control-label mb-10 text-left" for="old_password">Senha atual</label>
                                            <input type="password" class="form-control" name="user[old_password]" id="old_password" placeholder="Senha atual" autocomplete="false" value="" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label class="control-label mb-10 text-left" for="password">Nova senha</label>
                                            <input type="password" class="form-control" name="user[password]" id="password" placeholder="Nova senha" autocomplete="false" value="" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label class="control-label mb-10 text-left" for="password_confirmation">Repita nova senha</label>
                                            <input type="password" class="form-control" name="user[password_confirmation]" id="password_confirmation" autocomplete="false" placeholder="Repita nova senha" value="" />
                                        </div>
                                    </div>
                                </fieldset>

                                {{-- <hr /> --}}
                                <button type="submit" class="btn btn-success my-4">
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

@push('bottom-scripts')
    <script>
        $(() => {
            $('#img_avatar').on('click', (e) => {
                e.preventDefault();
                $('#avatar').trigger('click');
            })

            $('#avatar').on('change', (e) => {
                $('#feedback_avatar').show();
            })
        })
    </script>
@endpush