@extends('layouts.app')

@section('title')
    Lista de tipo de declaração
@endsection

@section('breadcrumbs')
    <li class="active"><span>Tipos de declaração</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Lista de tipos de declaração</h6>
                
                    <a href="{{ route('declaration_types.create') }}" class="btn btn-success btn-sm">
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
                                        <th>Nome</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="align-middle">
                                            <td>{{ $row->name }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('declaration_types.edit', ['declaration_type' => $row]) }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form onclick="return confirme('Tem certeza?')" action="{{ route('declaration_types.destroy', ['declaration_type' => $row]) }}" method="POST" style="display:inline">
                                                    @method('DELETE')
                                                    @csrf
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
