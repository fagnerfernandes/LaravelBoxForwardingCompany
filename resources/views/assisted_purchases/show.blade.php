@extends('layouts.app')

@section('title')
    Detalhes da compra assistida
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('assisted-purchases.index') }}"><span>Compras assistidas</span></a></li>
    <li class="active"><span>Compra assistida</span></li>
@endsection

@section('wrapper')
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-body">
                    <h6>Detalhes da compra assistida</h6>


                    {{-- Listagem de items do pacote --}}
                    <p>
                        <span>Título</span> {{ $assisted_purchase->title }}
                    </p>
                    <p>
                        <span>Link</span> <a href="{{ $assisted_purchase->link }}" target="_blank">
                            {{ $assisted_purchase->link }}
                        </a>
                    </p>
                    <p>
                        <span>Preço</span> R$ {{ number_format($assisted_purchase->price, 2, ',', '.') }}
                    </p>
                    <p>
                        <span>Quantidade</span> {{ $assisted_purchase->quantity }}
                    </p>
                    <p>
                        <span>Cor </span> {{ $assisted_purchase->color ?? '' }}
                    </p>
                    <p>
                        <span>Segunda opção de cor </span> {{ $assisted_purchase->color_optional ?? '' }}
                    </p>
                    <p>
                        <span>Tamanho </span> {{ $assisted_purchase->size ?? '' }}
                    </p>
                    <p>
                        <span>Segunda opção de tamanho </span> {{ $assisted_purchase->size_optional ?? '' }}
                    </p>
                    <p>
                        <span>Observações </span> {{ $assisted_purchase->observations ?? '' }}
                    </p>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ URL::previous() }}" class="btn btn-light">
                            voltar
                        </a>

                        <div>
                            @if ((int)$assisted_purchase->status === 0)
                                <a href="{{ route('assisted-purchases.approved', ['id' => $assisted_purchase->id]) }}" class="btn btn-info">
                                    <i class="zmdi zmdi-file"></i> Aprovar (liberar pagamento)
                                </a>
                            @else
                                <a href="{{ route('assisted-purchases.finished', ['id' => $assisted_purchase->id]) }}" class="btn btn-success" onclick="return confirm('Confirma a finalização da compra?')">
                                    <i class="zmdi zmdi-check"></i> Compra efetuada
                                </a>
                            @endif

                            <a href="{{ route('assisted-purchases.canceled', ['id' => $assisted_purchase->id]) }}" class="btn btn-danger" onclick="return confirm('Confirma o cancelamento da compra?')">
                                <i class="zmdi zmdi-minus-circle-outline"></i> Cancelar compra
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
    <style>
        .panel-body p {
            padding: 0.3rem 0;
            border-bottom: 0.08rem solid #eee;
        }
        .panel-body p span {
            display: inline-block;
            width: 25%;
            padding: 0.2rem;
            font-weight: bolder;
        }
        .panel-body p span:after {
            content: ": ";
        }
    </style>
@endsection
