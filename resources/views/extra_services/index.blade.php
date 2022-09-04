@extends('layouts.app')

@section('title')
    Lista de serviços extras
@endsection

@section('breadcrumbs')
    <li class="active"><span>Serviços extras</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6> Lista de serviços extras</h6>
                        <a href="{{ route('extra-services.create') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus"></i> Adicionar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <div class="table-wrap">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Preço</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="align-middle">
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ number_format($row->price, 2, ',', '.') }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('extra-services.edit', ['extra_service' => $row]) }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-light">
                                                    <i class="bx bx-trash"></i>
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
