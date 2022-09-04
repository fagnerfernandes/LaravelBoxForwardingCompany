@extends('layouts.app')

@section('title')
    Lista de compras assistidas
@endsection

@section('breadcrumbs')
    <li class="active"><span>Compras assistidas</span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <h6>Lista de compras assistidas</h6>
            </div>
            <div class="card-body">
                {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                <div class="table-wrap mt-10">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Título</th>
                                    <th>Cor</th>
                                    <th>Preço Unit.</th>
                                    <th>Quantidade</th>
                                    <th>Subtotal</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->color }}</td>
                                        <td>$ {{ number_format($row->price, 2, ',', '.') }}</td>
                                        <td>{{ $row->quantity }}</td>
                                        <td>$ {{ number_format($row->price * $row->quantity, 2, ',', '.') }}</td>
                                        <td>{{ $row->transaction->status_text ?? $row->status_text }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('assisted-purchases.show', ['assisted_purchase' => $row]) }}" class="btn btn-sm btn-light">
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
