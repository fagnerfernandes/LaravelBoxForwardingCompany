@extends('layouts.app')

@section('title')
    Declaração de conteúdo do envio
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.shippings.index') }}">Meus envios</a></li>
    <li class="active"><span>Declaração de conteúdo do envio</span></li>
@endsection

@section('wrapper')
    <form action="{{ route('customer.shippings.declarationPost') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Basic Table -->
            <div class="col-sm-12">

                @include('customer.shippings.steps', ['step' => 3])

                <div class="card round-10 w-100">
                    <div class="card-header">
                        <h4 class="panel-title txt-dark"><i class="zmdi zmdi-airplane"></i> Declaração de conteúdo do envio</h4>
                        <p><small>Informe os dados para emitirmos a declaração de conteúdo</small></p>
                    </div>

                    <div class="card-body">
                        <div class="panel-body">
                            <div class="table-responsive mb-4">
                                <table class="table table-hover" id="table-items">
                                    <thead>
                                        <tr>
                                            <th>Imagem</th>
                                            <th>Código</th>
                                            <th>Observação</th>
                                            <th>Quantidade</th>
                                            <th>Categoria</th>
                                            <th>Declaração</th>
                                            <th>Valor declarado (USD)</th>
                                            <th>Qtd. declarada</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (session()->get('items') as $key => $item)
                                            <tr class="align-middle row-item">
                                                <td>
                                                    <a href="{{ asset('storage/package-items/'. $item['image']) }}" data-fancybox="gallery" data-caption="{{ $item['package_item_id'] }} - {{ $item['description'] }}">
                                                        <img src="{{ asset('storage/package-items/'. $item['image']) }}" alt="Foto do pacote" width="50" />
                                                    </a>
                                                </td>
                                                <td>PROD{{ $item['package_item_id'] }}</td>
                                                <td>{{ $item['description'] }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>
                                                    <input type="hidden" name="items[{{ $key }}][package_item_id]" value="{{ $item['package_item_id'] }}" />
                                                    <select required name="items[{{ $key }}][declaration_type_id]" id="declaration_type_id_{{ $key }}" class="form-select form-select-sm form-control form-control-sm" required>
                                                        <option value=""></option>
                                                        @foreach ($types as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" required name="items[{{ $key }}][declaration]" id="declaration_{{ $key }}" rows="3" class="form-control form-control-sm" required placeholder="Inserir declaração" />
                                                </td>
                                                <td>
                                                    <input type="number" required step="0.01" min="0" name="items[{{ $key }}][value]" class="form-control form-control-sm input_declaration_value" required placeholder="Inserir valor declarado" />
                                                </td>
                                                <td>
                                                    {{-- <select name="items[{{ $key }}][declaration_amount]" class="form-control form-control-sm form-select form-select-sm" required>
                                                        @for ($i = 1; $i <= $item['quantity']; $i++)
                                                            <option value="{{ $i }}" {{ (!empty($item['quantity']) && $item['quantity'] == $i) ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select> --}}
                                                    <input type="number" required step="1" min="0" name="items[{{ $key }}][declaration_amount]" class="form-control form-control-sm input_declaration_amount" placeholder="Inserir quantidade declarada" />
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('customer.shippings.declarationDestroy', ['package_item_id' => $item['package_item_id']]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente remover este item?')">
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td>$ <span id="total_declaraion_value" class="fw-bold">0.00</span></td>
                                            <td><span id="total_declaraion_amount" class="fw-bold">0</span></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ URL::previous() }}" class="btn btn-sm btn-light"><i class="bx bx-chevron-left"></i> voltar</a>
                                <button type="submit" class="btn btn-primary btn-next">Próximo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <x-modal-declaration-warning></x-modal-declaration-warning>
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
    <script>
        function calculateTotalAmount() {
            let total = 0
            const items = document.querySelectorAll('.input_declaration_amount')
            items.forEach(item => {
                total += parseInt(item.value) || 0
            })
            $('#total_declaraion_amount').text(total)
        }

        function calculateTotalValue() {
            let total = 0
            const items = document.querySelectorAll('.input_declaration_value')
            items.forEach(item => {
                total += parseFloat(item.value) || 0
            })
            $('#total_declaraion_value').text( Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(total) )
        }

        $(function() {

            $('#modalDeclarationWarning').modal('show')

            $('.input_declaration_amount').on('change', function() {
                calculateTotalAmount()
            })

            $('.input_declaration_amount').on('keyup', function() {
                calculateTotalAmount()
            })

            $('.input_declaration_value').on('change', function() {
                calculateTotalValue()
            })

            $('.input_declaration_value').on('keyup', function() {
                calculateTotalValue()
            })
        })
    </script>
@endsection
