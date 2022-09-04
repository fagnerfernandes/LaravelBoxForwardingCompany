@extends('layouts.app')

@section('title')
    Lista de serviços premium
@endsection

@section('breadcrumbs')
    <li class="active"><span>Serviços premium</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Lista de serviços premium</h4>
                    
                        <a href="{{ route('premium_services.create') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus"></i> Adicionar
                        </a>
                    </div>
                    <div class="">
                        {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                        <div class="table-wrap mt-40">
                            <div class="table-responsive mb-4">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Preço</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $row)
                                            <tr class="align-middle">
                                                <td>{{ $row->name }}</td>
                                                <td>$ {{ number_format($row->price, 2) }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('premium_services.edit', ['premium_service' => $row]) }}" class="btn btn-sm btn-light">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('premium_services.destroy', ['premium_service' => $row]) }}" style="display: inline" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light" onclick="return confirm('Tem certeza que deseja remover este item?')">
                                                            <i class='bx bx-trash'></i>
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
