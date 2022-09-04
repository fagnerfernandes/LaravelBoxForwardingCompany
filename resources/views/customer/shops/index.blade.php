@extends('layouts.app')

@section('title')
    Onde comprar
@endsection

@section('breadcrumbs')
    <li class="active"><span>Onde comprar</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class="">Onde comprar</h6>
                </div>
                <div class="card-body">
                    
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <div class="table-wrap">
                        <div class="row">
                            @forelse ($rows as $row)
                            <div class="col-sm-6 col-md-3">
                                <div class="card" style="height: 360px;">
                                    <img src="{{ asset('storage/shops/'. $row->logo) }}" alt="Logo - {{ $row->nome }}" width="100%" height="200" style="object-fit: cover" />
                                    <div class="card-body">
                                        <div class="d-flex flex-column justify-content-end align-items-center">
                                            <h3 class="text-center">{{ $row->name }}</h3>
                                            <p class="mt-2">
                                                <a href="{{ $row->link }}" target="_blank" class="btn btn-primary" role="button">Acessar</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                
                            @endforelse
                        </div>
                        
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
@endsection
