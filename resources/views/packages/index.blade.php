@extends('layouts.app')

@section('title')
    Lista de pacotes
@endsection

@section('breadcrumbs')
    <li class="active"><span>Pacotes</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="">Lista de pacotes</h6>

                    <a href="{{ route('packages.create') }}" class="btn btn-success btn-sm">
                        <i class="bx bx-plus"></i> Adicionar
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                <div class="table-wrap mt-40">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Código</th>
                                    <th>Cliente</th>
                                    <th>Localização</th>
                                    <th>Cod. Rastreio</th>
                                    <th>Nome</th>
                                    <th>Peso</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $row)
                                    <tr class="align-middle">
                                        <td>
                                            <a href="{{ url('storage/packages/'. $row->photo) }}" data-fancybox="gallery" data-caption="{{ $row->sku }} - {{ $row->name }}">
                                                <img src="{{ url('storage/packages/'. $row->photo) }}" alt="Foto do pacote" width="50" height="50" style="object-fit: cover" />
                                            </a>
                                        </td>
                                        <td>PKG{{ $row->id }}</td>
                                        <td>{{ $row->customer->name }}</td>
                                        <td>{{ $row->location ?? '' }}</td>
                                        <td>{{ $row->tracking_code }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->weight }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('package-items.index', ['package_id' => $row->id]) }}" class="btn btn-sm btn-light">
                                                <i class="bx bx-search"></i>
                                            </a>
                                            <a href="{{ route('packages.edit', ['package' => $row]) }}" class="btn btn-sm btn-light">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <form action="{{ route('packages.destroy', ['package' => $row]) }}" style="display: inline" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-light" onclick="return confirm('Deseja realmente remover este item?')">
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
