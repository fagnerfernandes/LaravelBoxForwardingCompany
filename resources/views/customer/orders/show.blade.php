@extends('layouts.app')

@section('title')
    Detalhes do pedido
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.orders.index') }}"><span>Pedidos da loja virtual</span></a></li>
    <li class="active"><span>Detalhes do pedido</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6>Detalhes do pedido</h6>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-2 mb-30">
                            <span class="block">Data do Pedido</span>
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>
                        
                        <div class="col-md-4 mb-30">
                            <span class="block">Status</span>
                            {{ $order->status_text }}
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantidade</th>
                                    <th>Peso</th>
                                    <th>Valor</th>
                                    <th>Subtotal</th>
                            </thead>
                            <tbody>
                                @php($value_total = $total_weight = 0)
                                @foreach ($order->items as $item)
                                    <tr class="align-middle">
                                        <td>
                                            {{ $item->product->code }} - 
                                            {{ $item->product->name }}
                                        </td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->product->weight }}</td>
                                        <td>{{ number_format($item->price, 2, '.', ',') }}</td>
                                        <td>{{ number_format($item->price * $item->amount, 2, '.', ',') }}</td>
                                    </tr>
                                    @php($value_total += ($item->price * $item->amount))
                                    @php($total_weight += $item->product->weight)
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>{{ $total_weight }}</td>
                                    <td colspan=""></td>
                                    <td>{{ $value_total }}</td>
                                </tr>
                            </tfoot>
                        </table>
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
