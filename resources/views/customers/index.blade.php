@extends('layouts.app')

@section('title')
    Clientes
@endsection

@section('breadcrumbs')
    <li class="active"><span>Clientes</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="panel-title txt-dark"><i class="zmdi zmdi-account"></i> Clientes</h6>
                
                    <a href="{{ url('/customers/create') }}" class="btn btn-success btn-sm">
                        <i class="bx bx-plus"></i> Adicionar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="panel-body">
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <div class="table-wrap mt-10">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>CPF</th>
                                    <th>Créditos</th>
                                    <th>Ativo</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($customers as $item)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->user->email }}</td>
                                            <td>{{ $item->document }}</td>
                                            <td>{{ $item->user->credits_total }}</td>
                                            <td>{{ (bool)$item->active ? 'Sim' : 'Não' }}</td>
                                            <td class="text-end col-md-3">
                                                <a href="{{ url('/addresses/' . $item->id) }}" title="Endereços do cliente" class="btn btn-light btn-sm">
                                                    <i class="bx bx-map"></i>
                                                </a>
                                                <a href="{{ route('customers.password.edit', ['customer' => $item]) }}" class="btn btn-light btn-sm" title="Alterar senha do cliente">
                                                    <i class="bx bx-key"></i>
                                                </a>
                                                <a href="{{ url('/customers/' . $item->id . '/edit') }}" title="Edit customer" class="btn btn-light btn-sm">
                                                    <i class="bx bx-edit"></i>
                                                </a>

                                                <form method="POST" action="{{ url('/customers' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-light btn-sm" title="Delete customer" onclick="return confirm(&quot;Confirm delete?&quot;)">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper"> {!! $customers->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Basic Table -->
</div>
@endsection
