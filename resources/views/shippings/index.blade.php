@extends('layouts.app')

@section('title')
    Solicitações de envio
@endsection

@section('breadcrumbs')
    <li class="active"><span>Solicitações de envio</span></li>
@endsection

@section('wrapper')
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6>Solicitações de envio</h6>
                </div>
                <div class="card-body">                    
                    <div class="panel-body">
                        <div class="table-wrap mt-40">
                            <div class="table-responsive mb-4">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Pagamento</th>
                                        <th>Rastreio</th>
                                        <th>Criado em</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($rows as $row)
                                    {{-- {{ dd($row) }} --}}
                                        <tr class="align-middle">
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->user->name }}</td>
                                            <td>R$ {{ number_format($row->value , 2) }}</td>
                                            <td>{{ $row->status_text }}</td>
                                            <td>
                                                {{-- @if($row->purchase_status_id) --}}
                                                    @switch($row->purchase_status_id)
                                                        @case(App\Enums\PurchaseStatusEnum::PAYED)
                                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                                <i class="bx bxs-circle me-1"></i>
                                                                Pago
                                                            </div>
                                                            @break
                                                    
                                                        @case(App\Enums\PurchaseStatusEnum::CANCELED)
                                                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                                <i class="bx bxs-circle me-1"></i>
                                                                Cancelado
                                                            </div>
                                                            @break
                                                        @default
                                                            <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                                                <i class="bx bxs-circle me-1"></i>
                                                                Aguardando Pagamento
                                                            </div>
                                                    @endswitch
                                                {{-- @else 
                                                    <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                                        <i class="bx bxs-circle me-1"></i>
                                                        Aguardando Pagamento
                                                    </div>
                                                @endif --}}
                                            </td>
                                            <td>{{ $row->tracking_code }}</td>
                                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('shippings.show', ['shipping' => $row->id]) }}" class="btn btn-sm btn-light">
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
