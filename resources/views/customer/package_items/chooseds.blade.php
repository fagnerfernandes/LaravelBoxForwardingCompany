@extends('layouts.app')

@section('title')
    Itens selecinados
@endsection

@section('breadcrumbs')
    <li class="active"><span>Serviços extras</span></li>
@endsection

@section("wrapper")
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            @include('customer.shippings.steps', ['step' => 2])

            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class="">Escolha os serviços extras</h6>
                </div>
                <div class="card-body">
                    <div class="table-wrap mt-40">
                        <form action="{{ route('customer.shippings.extra-services') }}" method="POST">
                            @csrf

                            @foreach (session()->get('items') as $key => $row)
                                <input type="hidden" name="items[{{ $key }}][package_item_id]" value="{{ $row['package_item_id'] }}" />
                                <input type="hidden" name="items[{{ $key }}][weight]" value="{{ $row['weight']*$row['quantity'] }}" />
                                <input type="hidden" name="items[{{ $key }}][amount]" value="{{ $row['quantity'] }}" />
                            @endforeach

                            <div class="row mb-2">
                                @foreach ($extra_services as $key => $service)
                                    <div class="col-md-4">
                                        <div class="card card-item" style="height: 140px; overflow: auto;">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h5 class="fs-6"><label for="service-{{ $key }}">{{ $service->name }}</label></h5>
                                                    <div>
                                                        <input type="checkbox" id="service-{{ $key }}" name="extra_services[{{ $key }}][id]" value="{{ $service->id }}" class="input-checkbox" />
                                                    </div>
                                                </div>
                                                <p>
                                                    <label for="service-{{ $key }}">
                                                        <input type="hidden" name="extra_services[{{ $key }}][name]" value="{{ $service->name }}" />
                                                        <input type="hidden" name="extra_services[{{ $key }}][price]" value="{{ $service->price }}" />
                                                        <input type="hidden" name="extra_services[{{ $key }}][weight]" value="{{ $service->weight }}" />
                                                        <strong>Preço: </strong> $ {{ number_format($service->price, 2) }}<br />
                                                        <strong>Peso adicional: </strong> {{ number_format($service->weight, 2) }} lbs<br />
                                                        <strong>Obs: </strong>{{ $service->description }}
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ URL::previous() }}" class="btn btn-sm btn-light"><i class="bx bx-chevron-left"></i> voltar</a>
                                <button type="submit" class="btn btn-primary btn-next">Próximo</button>
                            </div>
                        </form>
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
            const options = document.querySelectorAll('.option')
            options.forEach(option => {

                option.addEventListener('change', e => {
                    console.log(e.target.value)

                    if (e.target.value == 'outro') {
                        e.target.closest('td').querySelector('textarea').classList.remove('hide')
                    } else {
                        e.target.closest('td').querySelector('textarea').classList.add('hide')
                    }
                })

            })
            
        })

        $(function() {
            $('.input-checkbox').on('click', function() {
                if ($(this).prop('checked')) {
                    $(this).parents('.card-item').addClass('item-selected')
                } else $(this).parents('.card-item').removeClass('item-selected')
            })
        })

    </script>


    <style>
        .item-selected {
            border: 1px solid #0a4e0a;
            background: #d9f7d9;
        }
    </style>
@endsection
