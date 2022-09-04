@extends('layouts.app')

@section('title')
    Endereço de entrega
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.shippings.index') }}">Meus envios</a></li>
    <li class="active"><span>Endereço de entrega</span></li>
@endsection

@section('wrapper')
    <form action="{{ route('customer.shippings.addressPost') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Basic Table -->
            <div class="col-sm-12">
                @include('customer.shippings.steps', ['step' => 4])

                <div class="card round-10 w-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="panel-title txt-dark"><i class="zmdi zmdi-airplane"></i> Escolha um endereço de entrega</h4>
                                <p class="m-0 p-0"><small>Você pode adicionar um novo endereço caso deseje</small></p>
                            </div>
                            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalNewAddress">
                                <i class="bx bx-plus"></i> novo endereço
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Basic Table -->

                        <div class="row">
                            @if (count($addresses))
                                @foreach ($addresses as $key => $address)
                                    <div class="col-md-4">
                                        <div class="card card-item">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h5 class="card-title">
                                                        <label for="address-{{ $key }}">{{ $address->name }}</label>
                                                    </h5>
                                                    <input type="radio" id="address-{{ $key }}" name="address_id" class="input-checkbox" value="{{ $address->id }}" required />
                                                </div>
                                                <p class="card-text">
                                                    <label for="address-{{ $key }}">
                                                        {{ $address->postal_code }}
                                                        {{ $address->street }}, {{ $address->number }}<br />
                                                        {{ !empty($address->complement) ? $address->complement .' - ' : '' }}
                                                        {{ $address->district }} - {{ $address->city }} - {{ $address->state }}
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    <p class="text-center">No momento não há endereços cadastrados</p>
                                </div>
                            @endif
                        </div>
                        
                        <hr />
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <a href="{{ URL::previous() }}" class="btn btn-sm btn-light"><i class="bx bx-chevron-left"></i> voltar</a>
                            <button type="submit" class="btn btn-primary">
                                Próximo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Modal -->
    <div class="modal fade" id="modalNewAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Novo endereço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.addresses.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="back_to_referer" value="1" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="name">Nome (exemplo: casa, trabalho, etc): </label>
                                    <input type="text" name="name" id="name" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="postal_code">CEP: </label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control cep endereco" required />
                                </div>
                            </div>
                            <div class="col-md-7 mb-3">
                                <div class="form-group">
                                    <label for="street">Logradouro: </label>
                                    <input type="text" name="street" id="street" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="number">Número: </label>
                                    <input type="text" name="number" id="number" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="complement">Complemento: </label>
                                    <input type="text" name="complement" id="complement" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="district">Bairro: </label>
                                    <input type="text" name="district" id="district" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="city">Cidade: </label>
                                    <input type="text" name="city" id="city" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="state">Estado: </label>
                                    <input type="text" name="state" id="state" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        .item-selected {
            border: 1px solid #0a4e0a;
            background: #d9f7d9;
        }
    </style>
    
    <script src="{{ asset('js/addresses/form.js') }}"></script>
    <script>
        $(function() {
            $('.input-checkbox').on('click', function() {
                $('.card-item').each(function() {
                    $(this).removeClass('item-selected')
                })
                $(this).parents('.card-item').addClass('item-selected')
            })
        })
    </script>
@endsection