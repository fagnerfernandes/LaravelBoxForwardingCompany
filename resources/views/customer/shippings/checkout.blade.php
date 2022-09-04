@extends('layouts.app')

@section('title')
    Finalizar solicitação de envio
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.shippings.index') }}">Meus envios</a></li>
    <li class="active"><span>Finalizar solicitação de envio</span></li>
@endsection

@section('wrapper')
    <form action="{{ route('customer.shippings.checkoutPost') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Basic Table -->
            <div class="col-sm-12">

                @include('customer.shippings.steps', ['step' => 6])

                <div class="card round-10 w-100">
                    <div class="card-header">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-airplane"></i> Finalizar solicitação de envio</h6>
                    </div>
                    <div class="card-body">
                        <div class="panel-body">
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-light">
                                @if (!empty(session()->get('shipping')))
                                    <div>
                                        <p>
                                            <small>Apelido do envio</small><br />
                                            {{ session()->get('shipping_name') }}
                                        </p>
                                        <input type="hidden" name="name" value="{{ session()->get('shipping.package_id') }}" />
                                    </div>
                                    <div>
                                        <p>
                                            <small>Peso total</small><br />
                                            {{ number_format(session()->get('weight.total'), 2) }} lbs
                                        </p>
                                    </div>
                                @endif
                            </div>

                            {{-- Dados ja cadastrados --}}
                            <h5>Itens da solicitação</h5>

                            <div class="table-responsive mb-4">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Imagem</th>
                                            <th>Código</th>
                                            <th>Item</th>
                                            <th>Qtde.</th>
                                            <th>Tipo</th>
                                            <th>Declaração</th>
                                            <th>Valor declarado</th>
                                            <th>Qtd. declarado</th>
                                            <th>Peso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($total = 0)
                                        @php($total_declaration_amount = 0)
                                        @php($total_value = 0)
                                        @php($total_quantity = 0)
                                        @foreach (session()->get('items') as $item)
                                            <tr class="align-middle">
                                                <td>
                                                    <a href="{{ asset('storage/package-items/'. $item['image']) }}" data-fancybox="gallery" data-caption="{{ 'PROD'. $item['package_item_id'] }} - {{ $item['description'] }}">
                                                        <img src="{{ asset('storage/package-items/'. $item['image']) }}" alt="Foto do pacote" width="50" />
                                                    </a>
                                                </td>
                                                <td>PROD{{ $item['package_item_id'] }}</td>
                                                <td>{{ $item['description'] }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>{{ $item['declaration_type'] }}</td>
                                                <td>{{ $item['declaration'] }}</td>
                                                <td>$ {{ number_format($item['value'], 2, ',', '.') }}</td>
                                                <td>{{ $item['declaration_amount'] }}</td>
                                                <td>{{ number_format($item['weight']*$item['quantity'], 2, ',', '.') }}</td>
                                            </tr>
                                            @php($total += $item['weight']*$item['quantity'])
                                            @php($total_declaration_amount += $item['declaration_amount'])
                                            @php($total_value += $item['value'])
                                            @php($total_quantity += $item['quantity'])
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>{{ $total_quantity }}</strong></td>
                                            <td colspan="2"></td>
                                            <td><strong>$ {{ number_format($total_value, 2, ',', '.') }}</strong></td>
                                            <td><strong>{{ $total_declaration_amount }}</strong></td>
                                            <td><strong>{{ number_format($total, 2, ',', '.') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <input type="hidden" name="declaration_total_price" value="{{$total_value}}" />
                            <input type="hidden" name="declaration_total_amount" value="{{$total_declaration_amount}}" />

                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="">Serviços extras</h5>
                                    @php($total_extra_services = 0)
                                    @if (count(session()->get('extra_services')))
                                        <ul class="list-group list-group-flush mb-4">
                                            @foreach (session()->get('extra_services') as $service)
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        {{-- <div class="fw-bold">Subheading</div> --}}
                                                        {{ $service['name'] }}
                                                    </div>
                                                    <span class="badge bg-primary rounded-pill">
                                                        R$ {{ number_format($service['price'], 2, ',', '.') }}
                                                    </span>
                                                </li>
                                                @php($total_extra_services += $service['price'])
                                            @endforeach
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <strong>TOTAL: ${{ number_format($total_extra_services, 2) }}</strong>
                                            </li>
                                        </ul>
                                    @else
                                        <p class="mb-4">não foram adicionados serviços extras</p>
                                    @endif
                                </div>
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-7">
                                    <h5 class="mb-2">Detalhes do envio </h5>
                                    <ul class="list-group list-group-flush mb-4">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>Entrega em: </strong>
                                            <div>
                                                {{ session()->get('address.street') }},
                                                {{ session()->get('address.number') }}
                                                {{ !empty(session()->get('address.complement')) ? ' - ' . session()->get('address.complement') : '' }}
                                                {{ !empty(session()->get('address.district')) ? ' - ' . session()->get('address.district') : '' }}
                                                {{ !empty(session()->get('address.city')) ? ' - ' . session()->get('address.city') : '' }}
                                                {{ !empty(session()->get('address.state')) ? ' - ' . session()->get('address.state') : '' }}
                                                {{ !empty(session()->get('address.postal_code')) ? ' - ' . session()->get('address.postal_code') : '' }}
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <strong>Tipo de embalagem: </strong>
                                            <div>
                                                {{ session()->get('shipping.package_id') }}
                                                <!-- - ${{ session()->get('shipping.package_price') }} -->
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <strong>Taxa Company: </strong>
                                            <div>
                                                @currency(session()->get('shipping.company_tax'))
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <strong>Prazo de entrega: </strong>
                                            <div>
                                                {{ session()->get('shipping.shipping_estimate') }} dias
                                            </div>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <strong>Valor total declarado: </strong>
                                            <div>
                                                @currency(session()->get('shipping.total_declarado'))
                                            </div>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <strong>Seguro: </strong>
                                            <div>
                                                <?php
                                                    if(session()->get('shipping.insurance')==1){
                                                        $value_insurance = session()->get('shipping.total_declarado')/100*0.4;
                                                    } else {
                                                        $value_insurance = 0;
                                                    }
                                                ?>
                                                @currency($value_insurance)
                                            </div>
                                        </li>

                                        
                                            @isset($freeShipping->max_value)
                                                @if (floatval(session()->get('shipping.price')) <= $freeShipping->max_value)
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <strong>Valor total do envio (frete, taxa, seguro, Serviços extras): </strong>
                                                        <span><s>@currency(session()->get('shipping.price'))</s></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center bg-primary text-white p-1">
                                                        <strong>Aplicado cortesia de envio</strong>
                                                        <strong>@currency(0.00)</strong>
                                                    </div>
                                                </li>
                                                @else
                                                <li>
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <strong>Valor total do envio (frete, taxa, seguro, Serviços extras): </strong>
                                                        <span>@currency(session()->get('shipping.price'))</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center bg-secondary text-white p-1">
                                                        <strong>Valor do envio ultrapassa o limite da cortesia.</strong>
                                                    </div>
                                                </li>
                                                @endif
                                            @endisset
                                            {{-- @if ($freeshipping && floatval(session()->get('shipping.price')) <= $freeShipping->max_value) 
                                                <div>
                                                    $ {{ number_format(session()->get('shipping.price'), 2, ',', '.') }}
                                                </div>
                                            @else
                                            @endif --}}                                                
                                            {{-- <div>
                                                $ {{ number_format(session()->get('shipping.price'), 2, ',', '.') }}
                                            </div> --}}
                                        {{-- </li> --}}
                                    </ul>
                                </div>
                            </div>

                            <hr />
                            <div class="d-flex justify-content-between align-item-center">
                                <a href="{{ URL::previous() }}" class="btn btn-sm btn-light"><i class="bx bx-chevron-left"></i> voltar</a>
                                <button type="submit" class="btn btn-primary">Finalizar solicitação de envio</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Basic Table -->
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/shippings/create.js') }}"></script>
@endsection
