@extends('layouts.app')

@section('title')
    Meus envios
@endsection

@section('breadcrumbs')
    <li class="active"><span>Meus envios</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6> Meus envios</h6>

                        <a href="{{ route('customer.items.available') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus"></i> Solicitar envio
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <x-search action="{{ route('customer.shippings.index') }}"></x-search>

                    <div class="">
                        <div class="">
                            <div class="table-responsive mb-4">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Código de Envio</th>
                                        <th>Apelido de envio</th>
                                        <th>Rastreio</th>
                                        <th>Modalidade de envio</th>
                                        <th>Criado em</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Pagamento</th>
                                        <th>Peso total</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="align-middle">
                                            <td>BOX{{ $row->id }}</td>
                                            <td>{{ $row->shipping_name ?? '' }}</td>
                                            <td>{{ !empty($row->tracking_code) ? $row->tracking_code : $row->status_text }}</td>
                                            <td>{{ !empty($row->shipping_form) ? $row->shipping_form->name : "" }}</td>
                                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                            <td>${{ number_format($row->value, 2) }}</td>
                                            <td>
                                                <div class="badge rounded-pill text-{{ $row->status_color }} bg-light-{{ $row->status_color }} p-2 text-uppercase px-3">
                                                    <i class="bx bxs-circle me-1"></i>
                                                    {{ $row->status_text }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($row->purchase)
                                                    @switch($row->purchase->purchase_status_id)
                                                        @case(App\Enums\PurchaseStatusEnum::PAYED)
                                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                                <i class="bx bxs-circle me-1"></i>
                                                                {{ $row->purchase->statusText() }}
                                                            </div>
                                                            @break
                                                    
                                                        @case(App\Enums\PurchaseStatusEnum::CANCELED)
                                                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                                <i class="bx bxs-circle me-1"></i>
                                                                {{ $row->purchase->statusText() }}
                                                            </div>
                                                            @break
                                                        @default
                                                            <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                                                <i class="bx bxs-circle me-1"></i>
                                                                {{ $row->purchase->statusText() }}
                                                            </div>
                                                    @endswitch
                                                @else 
                                                    <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                                        <i class="bx bxs-circle me-1"></i>
                                                        Aguardando Pagamento
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ number_format($row->weight, 2) .' lbs' }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.shippings.show', [$row->id]) }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $rows->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
@endsection
