@extends('layouts.app')

@section('title')
    Lista de endereços
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customers.index') }}"><span>Clientes</span></a></li>
    <li class="active"><span>Endereços</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="panel-title txt-dark">Lista de endereços</h4>
                
                    <a href="{{ route('addresses.create', ['user' => $user]) }}" class="btn btn-success btn-sm">
                        <i class="bx bx-plus"></i> Adicionar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="panel-body">
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <div class="table-wrap mt-40">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>CEP</th>
                                        <th>Logradouro</th>
                                        <th>Número</th>
                                        <th>Cidade</th>
                                        <th>UF</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="align-middle">
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->postal_code }}</td>
                                            <td>{{ $row->street }}</td>
                                            <td>{{ $row->number }}</td>
                                            <td>{{ $row->city }}</td>
                                            <td>{{ $row->state }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('addresses.edit', ['user' => $row->user, 'address' => $row]) }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-edit"></i>
                                                </a>

                                                <form action="{{ route('addresses.destroy', ['user' => $row->user, 'address' => $row]) }}" method="POST" style="display: inline">
                                                    @method('DELETE')
                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-light" onclick="return confirm('Deseja realmente remover este item?')">
                                                        <i class="bx bx-trash"></i>
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