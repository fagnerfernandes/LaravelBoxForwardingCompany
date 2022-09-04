@extends('layouts.app')

@section('title')
    Detalhes do envio
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('shippings.index') }}"><span>Solicitações de envio</span></a></li>
    <li class="active"><span>Detalhes do envio</span></li>
@endsection

@section('wrapper')

    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-body">
                    <h6>Detalhes do envio</h6>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-1 mb-4">
                                <span class="block">N<sup>o</sup></span>
                                {{ $shipping->id }}
                            </div>

                            <div class="col-md-2 mb-4">
                                <span class="block">Data da solicitação</span>
                                {{ $shipping->created_at->format('d/m/Y H:i') }}
                            </div>

                            <div class="col-md-2 mb-4">
                                <span class="block">Status</span>
                                {{ $shipping->status_text }}
                            </div>

                            <div class="col-md-2 mb-4">
                                <span class="block">Valor total</span>
                                R$ {{ number_format($shipping->value , 2) }}
                            </div>

                            <div class="col-md-5 mb-4">
                                <span class="block">Cliente</span>
                                {{ $shipping->user->name }}
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Quantidade</th>
                                        <th>Peso</th>
                                        <th>Tipo</th>
                                        <th>Declaração</th>
                                        <th>Valor declarado</th>
                                        <th>Qtd. declarado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($amount_total = $value_total = $total_weight = $total_items = 0)
                                    @foreach ($shipping->items as $item)
                                        <tr class="align-middle">
                                            <td>
                                                <a href="{{ asset('storage/package-items/'. $item->package_item->image) }}" data-fancybox="gallery" data-caption="{{ $item->package_item->sku }} - {{ $item->package_item->description }}">
                                                    <img src="{{ asset('storage/package-items/'. $item->package_item->image) }}" alt="Foto do pacote" width="50" />
                                                </a>
                                            </td>
                                            <td>
                                                {{ $item->package_item->reference }} -
                                                {{ $item->package_item->description }}
                                            </td>
                                            <td>{{ $item->amount }}</td>
                                            <td>{{ $item->weight }}</td>
                                            <td>{{ $item->declaration_type->name ?? '' }}</td>
                                            <td>{{ $item->declaration }}</td>
                                            <td>{{ $item->declaration_price }}</td>
                                            <td>{{ $item->declaration_amount }}</td>
                                        </tr>
                                        @php($amount_total += $item->amount)
                                        @php($value_total += $item->declaration_price)
                                        @for ($i = 0 ; $i < $item->amount; $i++)
                                            @php($total_weight += $item->weight)
                                        @endfor
                                        @php($total_items += $item->declaration_amount)
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>{{ $amount_total }}</td>
                                        <td>{{ $shipping->weight_mensured ? number_format($shipping->weight_mensured, 2).' (Peso aferido) lbs' : number_format($total_weight, 2) . ' lbs' }}</td>
                                        <td colspan="2"></td>
                                        <td>$ {{ number_format($value_total, 2) }}</td>
                                        <td>{{ $total_items }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="my-4">
                            <fieldset>
                                <legend class="mb-20">Serviços extras</legend>
                                <ul class="list-group">
                                    {{-- @php(dump($shipping->extra_services)) --}}
                                    @foreach ($shipping->extra_services as $service)
                                        <li class="list-group-item">
                                            <span class="badge">{{ $service->price }}</span>
                                            <h6 class="fs-6 list-group-item-heading">{{ $service->extra_service->name }}</h6>
                                            <p class="list-group-item-text">{{ $service->extra_service->description }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </fieldset>
                        </div>

                        @if ((int)$shipping->status ==1 && $shipping->label==null && $shipping->boxes_id!=null)
                        <fieldset class="form mt-4">
                                <legend class="mb-10">Etiqueta</legend>
                                <div class="form-group mb-3">
                                   <a href="{{ env('APP_URL') }}/shippings/label/{{ $shipping->id}}">Gerar etiqueta</a>
                                </div>
                                <div class="form-group mb-3">
                                    <button class="btn btn-primary" id="btnAlteraPeso" data-bs-toggle="modal" data-bs-target="#modalAlterarPeso">Alterar Peso</button>
                                </div>
                        </fieldset>
                        @endif

                        @if ($shipping->label!=null)
                        <fieldset class="form mt-4">
                                <legend class="mb-10">Etiqueta</legend>
                                <div class="form-group mb-3">
                                    <a href="{{ $shipping->label}}" target="_blank">Visualizar Etiqueta</a>
                                </div>
                                <div class="form-group mb-3">
                                    <a href="{{ $shipping->shipping_invoice}}" target="_blank">Visualizar Invoice</a>
                                </div>
                        </fieldset>
                        @endif

                        @if ((int)$shipping->status < 2)
                            <fieldset class="form mt-4">
                                <legend class="mb-10">Dados do envio</legend>

                                <form action="{{ url('shippings/'. $shipping->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    @if ((int)$shipping->status ==1 && $shipping->label==null)
                                    <div class="form-group mb-3 col-md-12">
                                        <label class="control-label mb-10 text-left" for="category_id">Caixa</label>
                                        <select class="form-control" name="boxes_id" id="boxes_id">
                                            <option value="">-- Selecione a caixa --</option>
                                            @foreach ($box as $id => $name)
                                                <option value="{{ $id }}" {{ (!empty($shipping->boxes_id) && $shipping->boxes_id == $id) ? 'selected="selected"' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    <div class="form-group mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control form-select">
                                            <option value=""></option>
                                            @foreach (['Pendente', 'Em progresso', 'Enviado', 'Cancelado'] as $key => $status)
                                                <option value="{{ $key }}" {{ ($key === (int)$shipping->status) ? 'selected="selected"' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tracking_code">Número de rastreamento</label>
                                        <input type="text" name="tracking_code" id="tracking_code" class="form-control" value="{{ $shipping->tracking_code }}" />
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="observation">Observações</label>
                                        <textarea name="observation" id="observation" rows="5" class="form-control">{{ $shipping->observation }}</textarea>
                                    </div>
                                    <br>

                                    <hr />
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('shippings.index') }}" class="btn btn-light">
                                            Voltar
                                        </a>

                                        <button type="submit" class="btn btn-success">
                                            <span class="btn-text">Gravar</span>
                                        </button>
                                    </div>
                                </form>
                            </fieldset>
                        @else
                        <hr>
                        <a href="{{ route('shippings.index') }}" class="btn btn-light">
                            Voltar
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>

    <style>
        .block {
            font-size: 0.7rem;
            display: block;
        }
    </style>
    <div class="modal fade show" id="modalAlterarPeso" tabindex="-1" aria-modal="true" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alteração de Peso do Pacote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('shipping.change-weight', ['shipping' => $shipping]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="newWeight">Novo Peso</label>
                                    <input type="number" name="newWeight" id="newWeight" class="form-control" value="{{ $shipping->weight_mensured ? $shipping->weight_mensured : $total_weight }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Gravar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('bottom-scripts')
    <script>
        $(()=> {

        })
    </script>
@endpush
