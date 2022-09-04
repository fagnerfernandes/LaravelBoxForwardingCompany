@extends("layouts.app")
@section('title')
    Lista de endereços
@endsection

@section('breadcrumbs')
    <li class="active"><span>Endereços</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">

                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-pin"></i> Lista de endereços</h6>

                        <a href="{{ route('customer.addresses.create') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus"></i> Adicionar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <x-search action="{{ url('customer/addresses') }}"></x-search>
                    <div class="table-wrap">
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
                                    {{--
                                    <form action="{{ route('customer.addresses.index') }}" method="GET">
                                        <tr>
                                            <td>
                                                <input type="text" name="id" value="{{ request()->get('id') ?? '' }}" class="form-control form-control-sm" />
                                            </td>
                                            <td>
                                                <input type="text" name="name" value="{{ request()->get('name') ?? '' }}" class="form-control form-control-sm" />
                                            </td>
                                            <td>
                                                <input type="text" name="postal_code" value="{{ request()->get('postal_code') ?? '' }}" class="form-control form-control-sm" />
                                            </td>
                                            <td>
                                                <input type="text" name="street" value="{{ request()->get('street') ?? '' }}" class="form-control form-control-sm" />
                                            </td>
                                            <td>
                                                <input type="text" name="number" value="{{ request()->get('number') ?? '' }}" class="form-control form-control-sm" />
                                            </td>
                                            <td>
                                                <input type="text" name="city" value="{{ request()->get('city') ?? '' }}" class="form-control form-control-sm" />
                                            </td>
                                            <td>
                                                <input type="text" name="state" value="{{ request()->get('state') ?? '' }}" class="form-control form-control-sm" />
                                            </td>
                                            <td class="text-end">
                                                <button type="submit" class="btn btn-sm">
                                                    <i class="bx bx-search"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                    --}}
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
                                                <a href="{{ route('customer.addresses.edit', ['address' => $row]) }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-edit"></i>
                                                </a>

                                                <form onclick="return confirm('Tem certeza?')" action="{{ route('customer.addresses.destroy', ['address' => $row]) }}" style="display: inline" method="POST">
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
                        <div class="pagination-wrapper"> {!! $rows->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>

@endsection
