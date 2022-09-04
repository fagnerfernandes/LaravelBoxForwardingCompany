@extends('layouts.app')

@section('title')
    Lista de onde comprar
@endsection

@section('breadcrumbs')
    <li class="active"><span>Lista de onde comprar</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h6>Lista de onde comprar</h6>
                
                    <a href="{{ url('/shops/create') }}" class="btn btn-success btn-sm">
                        <i class="bx bx-plus"></i> Adicionar
                    </a>
                </div>
            
                {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                <div class="table-wrap mt-10">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover mb-0">
                            <thead>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($shops as $item)
                                    <tr class="align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->link }}</td>
                                        <td>{{ $item->status_text }}</td>
                                        <td class="text-end">
                                            <a href="{{ url('/shops/' . $item->id) }}" title="View shop" class="btn btn-light btn-sm">
                                                <i class="bx bx-search"></i>
                                            </a>
                                            <a href="{{ url('/shops/' . $item->id . '/edit') }}" title="Edit shop" class="btn btn-light btn-sm">
                                                <i class="bx bx-edit"></i>
                                            </a>

                                            <form method="POST" action="{{ url('/shops' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-light btn-sm" title="Delete shop" onclick="return confirm(&quot;Confirm delete?&quot;)">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-wrapper"> {!! $shops->appends(['search' => Request::get('search')])->render() !!} </div>
                </div>
        
            </div>
        </div>
    </div>
    <!-- /Basic Table -->
</div>
@endsection
