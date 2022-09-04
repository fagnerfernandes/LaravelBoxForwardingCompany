@extends('layouts.app')

@section('title')
    Movimentações de estoque
@endsection

@section('breadcrumbs')
    <li class="active"><span>Movimentações de estoque</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="pull-left">
                    <h4 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Movimentações de estoque</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('stocks.create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-fw fa-plus"></i> Adicionar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="panel-body">
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <div class="table-wrap mt-40">
                        <div class="table-responsive mb-4">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Produto</th>
                                        <th>Tipo</th>
                                        <th>Quantidade</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr>
                                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $row->product->name }}</td>
                                            <td>{{ $row->type_text }}</td>
                                            <td>{{ $row->amount }}</td>
                                            <td class="text-right">
                                                <form onclick="return confirm('Você tem certeza?')" action="{{ route('stocks.destroy', ['stock' => $row]) }}" style="display:none" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-default">
                                                        <i class="fa fa-fw fa-trash-o"></i> remover
                                                    </button>
                                                </form>
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
