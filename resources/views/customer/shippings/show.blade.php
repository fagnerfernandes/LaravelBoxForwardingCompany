@extends('layouts.app')

@section('title')
    Detalhes do envio
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.shippings.index') }}"><span>Meus envios</span></a></li>
    <li class="active"><span>Detalhes do envio</span></li>
@endsection

@section('wrapper')
    <div class="row">
        <div class="col-md-3">
            <x-card-component
                title="Código do envio"
                value="{{ $shipping->id }}"
                icon="bx-cart"
            ></x-card-component>
        </div>
        <div class="col-md-3">
            <x-card-component
                title="Data da solicitação"
                value="{{ $shipping->created_at->format('d/m/Y H:i') }}"
                icon="bx-cart"
            ></x-card-component>
        </div>
        <div class="col-md-3">
            <x-card-component
                title="Status"
                value="{{ $shipping->status_text }}"
                icon="bx-cart"
            ></x-card-component>
        </div>
        <div class="col-md-3">
            <x-card-component
                title="Valor total"
                value="{{ (new \NumberFormatter('en_US', \NumberFormatter::CURRENCY))->formatCurrency($shipping->value, 'USD') }}"
                icon="bx-cart"
            ></x-card-component>
        </div>
        <div class="col-md-3">
            <x-card-component
                title="Cliente"
                value="<small>{{ $shipping->user->name }}</small>"
                icon="bx-cart"
            ></x-card-component>
        </div>
        <div class="col-md-3">
            <x-card-component
                title="Modalidade de envio"
                value="{{ $shipping->shipping_form->name ?? '-' }}"
                icon="bx-cart"
            ></x-card-component>
        </div>
        <div class="col-md-3">
            <x-card-component
                title="Código de rastreio"
                value="{{ $shipping->tracking_code ?? '-' }}"
                icon="bx-cart"
            ></x-card-component>
        </div>
        <div class="col-md-3">
            <x-card-component
                title="Nome do envio"
                value="{{ $shipping->shipping_name ?? '-' }}"
                icon="bx-cart"
            ></x-card-component>
        </div>
    </div>

    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-body">
                    <h6>Detalhes do envio</h6>

                    <div class="panel-body">

                        <div class="table-responsive my-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Imagem</th>
                                        <th>Observação</th>
                                        <th>Quantidade Enviada</th>
                                        <th>Peso</th>
                                        <th>Tipo</th>
                                        <th>Declaração</th>
                                        <th>Quantiade declarada</th>
                                        <th>Valor declarado</th>
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
                                            <td>{{ $item->weight }} lbs</td>
                                            <td>{{ $item->declaration_type->name ?? '' }}</td>
                                            <td>{{ $item->declaration }}</td>
                                            <td>{{ $item->declaration_amount }}</td>
                                            <td>@currency($item->declaration_price)</td>
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
                                        <td>{{ number_format($total_weight, 2) }} lbs</td>
                                        <td colspan="2"></td>
                                        <td>{{ $total_items }}</td>
                                        <td>@currency($value_total)</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                       {{--  <div class="my-4">
                            <fieldset>
                                <legend class="mb-20">Serviços extras</legend>
                                @if (!empty($shipping->extra_services))
                                    <ul class="list-group">
                                        @foreach ($shipping->extra_services as $service)
                                            <li class="list-group-item">
                                                <span class="badge">{{ $service->price }}</span>
                                                <h6 class="fs-6 list-group-item-heading">{{ $service->extra_service->name }}</h6>
                                                <p class="list-group-item-text">{{ $service->extra_service->description }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-center">
                                        <small>não foi selecionado nenhum serviço extra para este pedido de envio.</small>
                                    </p>
                                @endif
                            </fieldset>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Serviços extras
                                    </div>
                                    <div class="card-body">
                                        @if (!empty($shipping->extra_services))
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
                                        @else
                                            <p class="text-center">
                                                <small>não foi selecionado nenhum serviço extra para este pedido de envio.</small>
                                            </p>
                                        @endif
                                    </div>
                                </div>   
                            </div>
                            {{-- @if ((int)$shipping->status === 0) --}}
                                <div class="col-md-6">
                                    <livewire:payment :withCredits="true" :transaction="null" :modelClass="App\Models\Shipping::class" :modelObject="$shipping" :amount="$shipping->value" />
                                </div>
                            {{-- @endif --}}
                        </div>
                            {{-- <div class="row">
                                <div class="col-6">
                                    <form style="display: inline" target="_blank" action="https://www.sandbox.PayPal.com/cgi-bin/webscr" method="post">
                                        @csrf

                                        <input type="hidden" name="amount" value="{{ number_format($shipping->value, 2, '.', '') }}" />
                                        <input type="hidden" name="business" value="fagner.ti@gmail.com" />
                                        <input type="hidden" name="item_name" value="Solicitacao de envio #{{ $shipping->id }}" />
                                        <input type="hidden" name="no_shipping" value="1" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="notify_url" value="{{ env('PAYPAL_URL_NOTIFY') }}" />
                                        <input type="hidden" name="cancel_return" value="{{ env('PAYPAL_URL_CANCEL') }}" />
                                        <input type="hidden" name="return" value="{{ env('PAYPAL_URL_RETURN') }}" />
                                        <input type="hidden" name="cmd" value="_xclick" />

                                        <button name="pay_now" type="submit" class="btn btn-info">
                                            <i class="lni lni-paypal-original"></i>
                                            Pagar com cartão
                                            <small>(paypal)</small>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <!-- BEGIN FORM CambioReal -->
                                    <form action="https://www.cambioreal.com/pagamento/carrinho" method="post" target="_blank">
                                    <input type="hidden" name="token" value="e3a2ef30-e100-4088-932e-30764ebb24da">
                                    <input type="hidden" name="account" value="1065">
                                    <input type="hidden" name="url_callback" value="https://company.com/">
                                    <input type="hidden" name="url_error" value="https://company.com/">
                                    <!-- Optional configuration fields -->
                                    <input type="hidden" name="currency" value="USD">
                                    <input type="hidden" name="duplicate" value="1">
                                    <input type="hidden" name="reference" value="Solicitacao de envio #{{ $shipping->id }}">
                                    <!-- Products -->
                                    <input type="hidden" name="produtos[0][descricao]" value="Cambio Real">
                                    <input type="hidden" name="produtos[0][valor]" value="{{ number_format($shipping->value, 2, '.', '') }}">
                                    <input type="hidden" name="produtos[0][ref]" value="ref">
                                    <input type="hidden" name="no-attach" value="1">
                                    <input type="image" src="https://www.cambioreal.com/botoes/bnt-cr-203x37.png" name="submit" alt="Pague com CambioReal" >
                                    </form>
                                    <!-- END FORM CambioReal -->

                                    <!-- <button type="submit" class="btn btn-success">
                                        <i class="lni lni-empty-file"></i>
                                        Pagar com boleto
                                        <small>(Cambio Real)</small>
                                    </button> -->
                                </div>
                            </div> 
                        @endif --}}
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
@endsection
