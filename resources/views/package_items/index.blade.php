@extends('layouts.app')

@section('title')
    Itens do pacote
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('packages.index') }}">Pacotes</a></li>
    <li class="active"><span>Itens do pacote</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="panel-title txt-dark">Itens do pacote</h6>

                        <a href="{{ route('package-items.create', ['package_id' => $package->id]) }}" class="btn btn-success btn-sm">
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
                                        <th>Imagem</th>
                                        <th>Código</th>
                                        <th>SKU</th>
                                        <th>Nome</th>
                                        <th>Peso</th>
                                        <th>Quantidade</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($package->items as $row)
                                        <tr class="align-middle">
                                            <td>
                                                <a href="{{ asset('storage/package-items/'. $row->image) }}" data-fancybox="gallery" data-caption="{{ $row->sku }} - {{ $row->name }}">
                                                    <img src="{{ asset('storage/package-items/'. $row->image) }}" alt="Foto do pacote" width="50" />
                                                </a>
                                            </td>
                                            <td>PROD{{ $row->id }}</td>
                                            <td>{{ $row->reference }}</td>
                                            <td>{{ $row->description }}</td>
                                            <td>{{ $row->weight }}</td>
                                            <td>{{ $row->amount }}</td>
                                            <td class="text-end">
                                                <form action="{{ route('package-items.destroy', ['id' => $row->id, 'package_id' => $row->package_id]) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-light" onclick="return confirm('Deseja realmente remover o item?')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
