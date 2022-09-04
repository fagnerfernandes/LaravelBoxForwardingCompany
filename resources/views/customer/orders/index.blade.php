@extends('layouts.app')

@section('title')
    Pedidos da loja virtual
@endsection

@section('breadcrumbs')
    <li class="active"><span>Pedidos da loja virtual</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6> Pedidos da loja virtual</h6>
                </div>
                <div class="card-body">

                    <x-search action="{{ route('customer.orders.index') }}"></x-search>
                    <div class="table-wrap mt-40">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>N<sup>o</sup> pedido</th>
                                        <th>Data do pedido</th>
                                        <th>Status</th>
                                        <th>Rastreio</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="align-middle">
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $row->status_text }}</td>
                                            <td>{{ $row->track_code }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.orders.show', ['order' => $row]) }}" class="btn btn-sm btn-light">
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
        <!-- /Basic Table -->
    </div>
@endsection
