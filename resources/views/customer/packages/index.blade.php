@extends('layouts.app')

@section('title')
    Pacotes recebidos
@endsection

@section('breadcrumbs')
    <li class="active"><span>Pacotes recebidos</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6>Pacotes recebidos</h6>
                </div>
                <div class="card-body">
                    <x-search action="{{ url('customer/addresses') }}"></x-search>
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <div class="table-wrap mt-40">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Imagem</th>
                                    <th>Observação</th>
                                    <th>Rastreio</th>
                                    <th>Cadastrado em</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="align-middle">
                                            <td>PKG{{ $row->id }}</td>
                                            <td>
                                                <a href="{{ asset('storage/packages/'. $row->photo) }}" data-fancybox="gallery" data-caption="{{ $row->sku }} - {{ $row->name }}">
                                                    <img src="{{ asset('storage/packages/'. $row->photo) }}" alt="Foto do pacote" width="60" height="60" style="object-fit: cover" />
                                                </a>
                                            </td>
                                            <td>{{ $row->name ?? '-' }}</td>
                                            <td>{{ $row->tracking_code }}</td>
                                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.packages.show', ['package' => $row->id]) }}" class="btn btn-sm btn-light">
                                                    <i class="bx bx-search"></i>
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
