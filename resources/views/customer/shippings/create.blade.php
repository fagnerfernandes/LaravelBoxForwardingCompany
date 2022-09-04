@extends('layouts.app')

@section('title')
    Solicitar envio
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.shippings.index') }}">Meus envios</a></li>
    <li class="active"><span>Solicitar envio</span></li>
@endsection

@section("wrapper")
    <form action="{{ '' }}" method="post">
        @csrf
        <div class="row">
            <!-- Basic Table -->
            <div class="col-sm-8">
                <div class="card round-10 w-100">
                    <div class="card-header">
                        <h4 class="panel-title txt-dark"><i class="zmdi zmdi-airplane"></i> Solicitar envio</h4>
                        <p><small>Marque os produtos que você deseja enviar</small></p>
                    </div>
                    <div class="card-body">
                        <div class="panel-body">
                            {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                            <div class="table-wrap mt-10">
                                <div class="table-responsive mb-4">
                                    <table class="table table-striped table-hover mb-0" id="table-items">
                                        <thead>
                                        <tr>
                                            <th>Imagem</th>
                                            <th>Código</th>
                                            <th>Nome</th>
                                            <th>Peso</th>
                                            <th class="col-md-2">Quantidade</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $key => $row)
                                                <tr>
                                                    <td>
                                                        <a href="{{ asset('storage/package-items/'. $row->image) }}" data-fancybox="gallery" data-caption="{{ $row->sku }} - {{ $row->description }}">
                                                            <img src="{{ asset('storage/package-items/'. $row->image) }}" alt="Foto do pacote" width="50" />
                                                        </a>
                                                    </td>
                                                    <td>PROD{{ $row->id }}</td>
                                                    <td>{{ $row->description }}</td>
                                                    <td class="item-weight">{{ $row->weight }}</td>
                                                    <td>
                                                        <select name="item[{{ $key }}][amount]" id="item_amount_{{ $key }}" class="form-control input-sm item-amount">
                                                            @for ($i = 1; $i <= $row->amount; $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5"><strong>Peso total: </strong></td>
                                                <td class="text-right"><strong id="weight-total">0</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card round-10 w-100">
                    <div class="card-header">
                        <h6 class="panel-title txt-dark">Finalizar a solicitação</h6>
                    </div>

                    <div class="panel-body">
                    <div class="form-group">
                            <label for="address_id">Endereço</label>
                            <select name="address_id" id="address_id" class="form-control">
                                <option value=""></option>
                                @foreach ($addresses as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group hide" id="payment_form">
                            <label for="">Escolha a forma de pagamento:</label>
                            <div id="options"></div>
                        </div>
                        <button type="submit" class="btn btn-success" id="btn-finish" disabled>
                            Finalizar solicitação
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Basic Table -->
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/shippings/create.js') }}"></script>
@endsection