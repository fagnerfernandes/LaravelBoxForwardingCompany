@extends('layouts.app')

@section('title')
    Meus pedidos de serviços premium
@endsection

@section('breadcrumbs')
    <li class="active"><span>Serviços premium</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="">Meus pedidos de serviços premium</h6>

                        <a href="{{ route('customer.premium_shoppings.create') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus"></i> Adicionar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <x-search action="{{ route('customer.premium_shoppings.index') }}"></x-search>
                    <div class="">

                        <div class="table-wrap mt-40">
                            <div class="table-responsive mb-4">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Imagem</th>
                                            <th>Código do produto</th>
                                            <th>Observação</th>
                                            <th>Serviço</th>
                                            <th>Valor</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $key => $row)
                                            <tr class="align-middle">
                                                <td>{{ $row->id }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/package-items/'. $row->package_item->image) }}" data-fancybox="gallery" data-caption="{{ $row->sku }} - {{ $row->name }}">
                                                        <img src="{{ asset('storage/package-items/'. $row->package_item->image) }}" alt="Foto do pacote" width="50" />
                                                    </a>
                                                </td>
                                                <td>{{ $row->package_item->reference ?? '' }}</td>
                                                <td>{{ $row->description }}</td>
                                                <td>{{ $row->premium_service->name }}</td>
                                                <td>{{ $row->price ?? 'a definir' }}</td>
                                                {{-- <td>{{ $row->transaction->status_text ?? 'Em aberto' }}</td> --}}
                                                <td>{{ $row->purchase->purchaseStatus->description ?? 'Aguardando Pagamento' }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('customer.premium_shoppings.show', ['premium_shopping' => $row]) }}" class="btn btn-light btn-sm">
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
        </div>
        <!-- /Basic Table -->
    </div>
@endsection

@section('scripts')

    <style>
        .sticky-top {
            top: 100px;
        }
    </style>

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


        document.addEventListener('DOMContentLoaded', () => {

            // Seleciona e desmarca os itens que deseja receber
            const selecteds = []
            const items = document.querySelectorAll('.item')
            items.forEach(item => {
                item.addEventListener('click', e => {
                    e.stopPropagation()

                    if (e.target.checked) {

                        const found = selecteds.filter(selected => selected.package_item_id == e.target.value ? true : false)
                        if (found.length == 0) {
                            selecteds.push({ 'package_item_id': e.target.value, 'amount': e.target.getAttribute('data-amount') })
                        }
                    } else {
                        const index = selecteds.findIndex(selected => selected.package_item_id == e.target.value)
                        selecteds.splice(index, 1)
                    }
                })
            })

            document.querySelector('.btn-next').addEventListener('click', e => {
                console.log('selecionar os serviços dos itens', selecteds)
            })
        })

    </script>
@endsection
