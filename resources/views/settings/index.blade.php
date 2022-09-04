@extends('layouts.app')

@section('title')
    Lista de configurações
@endsection

@section('breadcrumbs')
    <li class="active"><span>Configurações</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Lista de configurações</h6>
                
                    <a href="{{ route('settings.create') }}" class="btn btn-success btn-sm">
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
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="align-middle">
                                            <td>{{ $row->description }}</td>
                                            <td>{{ $row->value }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('settings.edit', ['setting' => $row]) }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form onclick="return confirm('Você tem certeza?')" action="{{ route('settings.destroy', ['setting' => $row]) }}" style="display:none" method="POST">
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
