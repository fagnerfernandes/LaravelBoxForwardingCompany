
@extends('layouts.app')

@section('title')
    Itens disponíveis
@endsection

@section('breadcrumbs')
    <li class="active"><span>Meu estoque</span></li>
@endsection

@section("wrapper")
    {{-- <div class="position-relative m-4">

        <div class="d-flex justify-content-between align-items-center">
            <div class="progress" style="height: 1px;">
                <div class="progress-bar" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">1</button>
            <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">2</button>
            <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">3</button>
            <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">4</button>
            <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">5</button>
            <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">6</button>
        </div>
    </div> --}}

    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            @include('customer.shippings.steps', ['step' => 1])

            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class="">Itens disponíveis</h6>
                </div>
                <div class="card-body">

                    <div class="bg-info text-white px-4 mb-2 py-2 sticky-top border-top border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Total de itens
                                <span class="fw-bolder" id="total_items">0</span>
                            </div>
                            <div>
                                Peso total
                                <span class="fw-bolder" id="total_weight">0.00</span> lbs
                            </div>
                        </div>
                    </div>

                    <p class="text-muted mb-4 pb-4">Para solicitar um envio, selecione os produtos e quantidade que deseja enviar e clique no botão "Próximo".</p>

                    <form action="{{ route('customer.items.chooseds') }}" id="formChoose" method="POST">
                        @csrf

                        <div class="mb-4 d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary">Próximo</button>
                        </div>

                        <div class="row">
                            @foreach ($rows as $key => $row)
                                <div class="col-md-4 col-xxl-3">
                                    <div class="card card-item radius-10" style="position: relative">
                                        <a href="{{ asset('storage/package-items/'. $row->image) }}" data-fancybox="gallery" data-caption="{{ $row->sku }} - {{ $row->name }}">
                                            <img src="{{ asset('storage/package-items/'. $row->image) }}" alt="Foto do pacote" width="100%" height="220" style="object-fit: contain" />
                                        </a>
                                        <div class="card-body mb-0 pb-0" style="font-size: 0.78rem">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="col-md-4 me-1">
                                                    <small class="text-secondary">Código</small>
                                                    <div class="bg-white text-start text-primary pb-2 radius-10 w-100">
                                                        PROD{{ $row->id }}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 offset-md-4 ms-1">
                                                    <small class="text-secondary">Quantidade</small>
                                                    <div class="bg-white text-start text-primary pb-2 radius-10 w-100">
                                                        <span class="stock">{{ $row->amount }}</span> {{ (int)$row->amount > 1 ? 'unidades' : 'unidade' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="text-center">
                                                    <small class="text-secondary">Tempo na suíte</small>
                                                    <div class="bg-primary text-white px-3 py-2 rounded w-100">
                                                        {{ Carbon\Carbon::now()->diffInDays($row->created_at) }} dias
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <small class="text-secondary">Recebido em</small>
                                                    <div class="bg-primary text-white px-2 py-2 rounded w-100">{{ $row->created_at->format('d/m/Y') }}</div>
                                                </div>
                                                <div class="text-center">
                                                    <small class="text-secondary">Peso unitário</small>
                                                    <div class="text-white bg-primary px-3 py-2 rounded w-100">
                                                        <span class="weight-unit">{{ $row->weight }}</span> lbs
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="text-center">{{ $row->description ?? '&nbsp;' }}</p>
                                        </div>
                                        <div class="card-footer bg-primary text-white">
                                            <div class="text-center">
                                                <div>
                                                    <fieldset class="">
                                                        <legend class="fs-6 text-center">Quantidade a enviar</legend>
                                                            <div class="checkbox" style="position: absolute; top: 10px; left: 10px;">
                                                                <div class="pretty p-round p-fill p-icon" style="background: #fff; border-radius: 50%; font-size: 2rem;">
                                                                    <input type="hidden" name="item[{{ $key }}][choosed]" value="0" />
                                                                    <input type="checkbox" class="choosed" name="item[{{ $key }}][choosed]" value="1" />
                                                                    <div class="state p-info">
                                                                        <i class="icon mdi mdi-check"></i>
                                                                        <label></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <input type="hidden" name="item[{{ $key }}][package_item_id]" value="{{ $row->id }}" />
                                                                <input type="hidden" name="item[{{ $key }}][sku]" value="{{ $row->sku }}" />
                                                                <input type="hidden" name="item[{{ $key }}][reference]" value="{{ $row->reference }}" />
                                                                <input type="hidden" name="item[{{ $key }}][description]" value="{{ $row->description }}" />
                                                                <input type="hidden" name="item[{{ $key }}][weight]" value="{{ $row->weight }}" />
                                                                <input type="hidden" name="item[{{ $key }}][image]" value="{{ $row->image }}" />
                                                                {{-- <select name="item[{{ $key }}][quantity]" id="quantity-{{ $key }}" class="form-control form-control-sm form-select form-select-sm input-quantity">
                                                                    <option value=""></option>
                                                                    @for ($i = 1; $i <= $row->amount; $i++)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                    @endfor
                                                                </select> --}}
                                                                <input type="number" name="item[{{ $key }}][quantity]" class="text-center form-control form-control-sm input-quantity" id="quantity-{{ $key }}" min="0" max="{{ $row->amount }}" placeholder="Inserir quantidade" />
                                                            </div>
                                                    </fieldset>
                                                    <p class="text-center">
                                                        Peso total: <span class="weight-total">{{ number_format($row->weight, 2) }}</span> lbs
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-end my-4">
                            <input type="hidden" name="shipping_name" />
                            <button type="submit" class="btn btn-primary btn-next">Próximo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>

    {{-- Modal de Escolha de nome do envio --}}
    <!-- Modal -->
    <div class="modal fade" id="modalShippingName" tabindex="-1" aria-labelledby="modalShippingNameLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalShippingNameLabel">Nome do envio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Para facilitar seu controle, você pode nomear seu envio</p>
                    <input type="text" class="form-control form-control-lg" id="shipping-name" />
                </div>
                <div class="modal-footer">
                    {{--  data-bs-dismiss="modal" --}}
                    <button type="button" class="btn btn-sm btn-secondary btn-choosed" data-option="false">Não, obrigado</button>
                    <button type="button" class="btn btn-sm btn-primary btn-choosed" data-option="true">Aplicar nome</button>
                </div>
            </div>
        </div>
    </div>
    {{-- /Modal de Escolha de nome do envio --}}

@endsection

@section('scripts')

    <style>
        .sticky-top {
            top: 60px;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            caption: (fancybox, carousel, slide) => {
                return (
                    `${slide.index + 1} / ${carousel.slides.length} <br />` + slide.caption
                )
            }
        })

        function updateQuantity(card, quantity) {
            console.log('mudou quantidade')
            const weight = parseFloat(card.find('.weight-unit').text())
            const stock = parseInt(card.find('.stock').text())

            if (quantity > 0 && quantity <= stock) {
                card.find('.weight-total').text(Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(weight * quantity))
            } else if (quantity > stock) {
                card.find('.weight-total').text(Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(weight * stock))
                card.find('.input-quantity').val(stock)
            } else card.find('.weight-total').text(Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(weight))
            console.log('quantidade', quantity)
            console.log('weight', weight)

            updateWeightTotal()
        }

        function updateWeightTotal() {
            let total = 0
            let totalItems = 0

            const items = document.querySelectorAll('.card-item')
            items.forEach(item => {
                const weight = parseFloat(item.querySelector('.weight-total').textContent)
                const quantity = parseInt(item.querySelector('.input-quantity').value)
                if (quantity > 0) {
                    total += weight
                    totalItems += quantity
                }
            })
            $('#total_weight').text( Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(total) )
            $('#total_items').text( totalItems )
        }

        $(function() {

            const modalShippingName = new bootstrap.Modal(document.getElementById('modalShippingName'), {})

            // Atualiza a quantidade
            $('.input-quantity').on('change', function() {
                const card = $(this).parents('.card-item')
                const quantity = parseInt($(this).val())
                updateQuantity(card, quantity)
            })

            $('.input-quantity').on('keyup', function() {
                const card = $(this).parents('.card-item')
                const quantity = parseInt($(this).val())
                updateQuantity(card, quantity)
            })

            $('#formChoose').on('submit', function(e) {
                e.preventDefault()

                const chooseds = $('.choosed:checked').length
                if (chooseds == 0) {
                    alert('Você precisa escolher pelo menos um item')
                    return
                }

                let hasError = false
                $('.choosed:checked').each(function() {
                    const item = $(this).parents('.card-item')
                    const quantity = item.find('.input-quantity').val()

                    if (quantity == "" || quantity == undefined || quantity == 0) {
                        hasError = true
                    }
                })

                if (hasError) {
                    alert('Por favor, informe a quantidade desejada para os itens que você selecionou.')
                    return
                }

                modalShippingName.show()

                // $('')
                // document.querySelector('#formChoose').submit()
            })


            $('.btn-choosed').on('click', function() {
                if ($(this).attr('data-option') == 'true') {
                    $('input[name=shipping_name]').val($('#shipping-name').val())
                }
                document.querySelector('#formChoose').submit()
            })

        })

    </script>
@endsection
