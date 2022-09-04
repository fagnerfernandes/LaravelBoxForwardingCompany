@extends('layouts.app')

@section('wrapper')
    <div class="card">
        <div class="card-header mt-2"><h6>Onde comprar {{ $shop->id }}</h6></div>
        <div class="card-body">

            <div class="table-responsive mb-4">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th><td>{{ $shop->id }}</td>
                        </tr>
                        <tr><th> Name </th><td> {{ $shop->name }} </td></tr><tr><th> Link </th><td> {{ $shop->link }} </td></tr><tr><th> Logo </th><td> {{ $shop->logo }} </td></tr>
                    </tbody>
                </table>
            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ url('/shops') }}" title="Back"><button class="btn btn-light btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> voltar</button></a>
                <div>
                    <a href="{{ url('/shops/' . $shop->id . '/edit') }}" title="Edit shop"><button class="btn btn-light btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> editar</button></a>

                    <form method="POST" action="{{ url('shops' . '/' . $shop->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete shop" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> remover</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
