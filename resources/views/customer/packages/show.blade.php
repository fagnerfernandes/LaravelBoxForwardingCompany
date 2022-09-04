@extends('layouts.app')

@section('title')
    Detalhes do pacote recebido
@endsection

@section('breadcrumbs')
    {{-- <li><a href="{{ route('customer.packages.index') }}"><span>Pacotes recebidos</span></a></li> --}}
    <li class="active"><span>Pacote recebido</span></li>
@endsection

@section('wrapper')
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-9">
            <div class="card round-10 w-100">
                {{--<div class="card-header"></div>--}}
                <div class="card-body">
                    {{-- Listagem de items do pacote --}}

                    <div class="table-responsive mb-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Referência</th>
                                    <th>Observação</th>
                                    <th>Qtd. recebida</th>
                                    <th>Qtd. disponível</th>
                                    <th>Qtd. Enviada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($package->items as $item)
                                    <tr class="align-middle">
                                        <td>
                                            @if (!empty($item->image))
                                                <a href="{{ asset('storage/package-items/'. $item->image) }}" data-fancybox="gallery" data-caption="{{ $package->sku }} - {{ $package->name }}">
                                                    <img src="{{ asset('storage/package-items/'. $item->image) }}" alt="Foto do pacote" width="50" height="50" style="object-fit: cover" />
                                                </a>
                                            @endif
                                        </td>
                                        <td>PROD{{ $item->id }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ ($item->amount - $item->amount_sent) }}</td>
                                        <td>{{ $item->amount_sent }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ URL::previous() }}" class="btn btn-light">
                        voltar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card round-10 w-100">
                <div class="panel-body">
                    <p>
                        <a href="{{ asset('storage/packages/'. $package->photo) }}" data-fancybox="gallery" data-caption="{{ $package->sku }} - {{ $package->name }}">
                            <img src="{{ asset('storage/packages/'. $package->photo) }}" alt="Foto do pacote" width="100%" class="img-responsive" />
                        </a>
                    </p>
                    <p class="font-16 py-2 text-center">
                        <strong>PKG{{ $package->id }}</strong><br />
                        Pacote recebido em {{ $package->created_at->format('d/m/Y H:i') }}<br/><br />
                        <strong>Cód. de Rastreio: </strong><span class="text-primary">{{ $package->tracking_code }}</span>
                    </p>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            caption: (fancybox, carousel, slide) => {
                return (
                    `${slide.index + 1} / ${carousel.slides.length} <br />` + slide.caption
                )
            }
        })
    </script>
@endsection
