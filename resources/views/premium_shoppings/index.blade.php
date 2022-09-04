@extends('layouts.app')

@section('title')
    Pedidos de serviços premium
@endsection

@section('breadcrumbs')
    <li class="active"><span>Pedidos de serviços premium</span></li>
@endsection

@section('wrapper')
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6>Pedidos de serviços premium</h6>
                </div>
                <div class="card-body">
                    <div class="panel-body">

                        <div class="table-wrap mt-40">
                            <div class="table-responsive mb-4">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Imagem</th>
                                            <th>Cliente</th>
                                            <th>SKU</th>
                                            <th>Nome</th>
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
                                                    <a href="{{ asset('storage/package-items/'. $row->image) }}" data-fancybox="gallery" data-caption="{{ $row->sku }} - {{ $row->name }}">
                                                        <img src="{{ asset('storage/package-items/'. $row->image) }}" alt="Foto do pacote" width="50" />
                                                    </a>
                                                </td>
                                                <td>{{ $row->user->name }}</td>
                                                <td>{{ $row->reference }}</td>
                                                <td>{{ $row->description }}</td>
                                                <td>{{ $row->premium_service->name }}</td>
                                                <td>{{ $row->price ?? 'a definir' }}</td>
                                                <td>{{ $row->status_text }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('premium_shoppings.show', ['premium_shopping' => $row]) }}" class="btn btn-light btn-sm">
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
