@extends('layouts.app')

@section('title')
    Detalhes do serviço premium
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.premium_shoppings.index') }}"><span>Serviços premium</span></a></li>
    <li class="active"><span>Detalhes do serviço premium</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Detalhes do serviço premium
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between mb-3">
                            <strong>N<sup>o</sup>: </strong>
                            <span>{{ $premium_shopping->id }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-between mb-3">
                            <strong>Data da solicitação: </strong>
                            <span>{{ $premium_shopping->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-between mb-3">
                            <strong>Serviço contratado: </strong>
                            <span>{{ $premium_shopping->premium_service->name }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-between mb-3">
                            <strong>Descrição do cliente: </strong>
                            <span>{{ $premium_shopping->service_description ?? '' }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-between mb-3">
                            <strong>Valor: </strong>
                            <span>
                                @if (!empty($premium_shopping->price))
                                    @currency($premium_shopping->price)
                                @else
                                    aguardando valor...
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-between mb-3">
                            <strong>Status: </strong>
                            <span>{{ $premium_shopping->transaction->status_text ?? 'Em aberto' }}</span>
                        </div>
                    </div>
                </div>
                    {{-- @if (!empty($premium_shopping->files) && count($premium_shopping->files))
                        <h4 class="mt-40 mb-10">Arquivos</h4>
    
                        <div class="list-group">
                            @foreach ($premium_shopping->files as $file)
                                <a href="{{ asset('storage/premium_shopping_files/'. $file->file) }}" target="_blank" class="list-group-item">
                                    {{ $file->file }}
                                </a>
                            @endforeach
                            </div>
                    @endif --}}
    
                    
            </div>
            {{-- @if ((int)$premium_shopping->status === 1 && blank($premium_shopping->transaction)) --}}
                <div class="col-md-12">
                    <livewire:payment :withCredits="true" :transaction="null" :modelClass="App\Models\PremiumShopping::class" :modelObject="$premium_shopping" :amount="$premium_shopping->price" />
                </div>
            {{-- @endif --}}
        </div>
        <!-- /Basic Table -->
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card round-10 w-100">
                        <div class="card-body">
                            <a href="{{ asset('storage/package-items/'. $premium_shopping->package_item->image) }}" data-fancybox="gallery" data-caption="{{ $premium_shopping->sku }} - {{ $premium_shopping->name }}">
                                <img src="{{ asset('storage/package-items/'. $premium_shopping->package_item->image) }}" alt="Foto do pacote" width="100%" />
                            </a>
                            <br />
                            <p class="text-center mt-4"><strong>Referência: </strong>{{ $premium_shopping->package_item->reference ?? '' }}</p>
                            <p class="text-center"><strong>Observação: </strong>{{ $premium_shopping->package_item->description ?? '' }}</p>
                            <p class="text-center"><strong>Quantidade de itens: </strong>{{ $premium_shopping->quantity ?? 1 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


@endsection

