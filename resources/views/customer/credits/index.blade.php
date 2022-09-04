@extends('layouts.app')

@section('title')
    Meus créditos
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page"><span>Créditos</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h4 class=""> Meus créditos</h4>

                        <a href="{{ route('customer.credits.create') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus"></i> Adicionar créditos
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                        <div class="table-wrap mt-40">
                            <div class="table-responsive mb-4">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th>Descrição</th>
                                            <th>Movimentação de</th>
                                            <th>Valor</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($total = 0)
                                        @foreach ($rows as $row)
                                            <tr class="align-middle {{ ($row->type == 'out') ? 'text-warning' : 'text-primary' }}">
                                                <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                                <td><?php if(isset($row->transaction->status)&&$row->transaction->status==1){echo 'Pago';} else { echo 'Aguardando pagamento';}?></td>
                                                <td>{{ $row->description }}</td>
                                                <td>{{ ($row->type == 'in') ? 'Entrada' : 'Saída' }}</td>
                                                <td>{{ (($row->type == 'out') ? '-' : '') . $row->amount }}</td>
                                                <td class="text-end">
                                                    {{-- @if (!(bool)$row->status) --}}
                                                        <a href="{{ route('customer.credits.show', ['credit' => $row]) }}" class="btn btn-light btn-sm">
                                                            <i class="bx bx-search"></i>
                                                        </a>
                                                    {{-- @endif --}}
                                                </td>
                                            </tr>
                                            <?php
                                                if(isset($row->transaction->status)&&$row->transaction->status==1){
                                                    $total += ($row->type == 'out') ? ($row->amount * (-1)) : $row->amount;
                                                }
                                            ?>

                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <strong>Total de créditos atualmente:</strong>
                                                <small>(* somente créditos confirmados)</small>
                                            </td>
                                            <td>
                                                <strong>{{ number_format($total, 2, '.', ',') }}</strong>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
@endsection
