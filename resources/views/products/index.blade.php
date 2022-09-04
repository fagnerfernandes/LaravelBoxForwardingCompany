@extends('layouts.app')

@section('title')
    Lista de Produtos
@endsection

@section('breadcrumbs')
    <li class="active"><span>Produtos</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Lista de produtos</h6>
                
                    <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
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
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Preço</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="align-middle">
                                            <td>{{ $row->code }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->price }}</td>
                                            <td>{{ $row->active ? 'Sim' : 'Não' }}</td>
                                            <td class="text-end">
                                                <a href="{{ url("/product-images/{$row->id}") }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-camera"></i>
                                                </a>

                                                <a href="{{ route('products.edit', ['product' => $row]) }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                
                                                <form onclick="return confirm('Você tem certeza?')" action="{{ route('products.destroy', ['product' => $row]) }}" style="display:none" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light">
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
