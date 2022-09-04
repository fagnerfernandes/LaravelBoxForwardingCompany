@extends('layouts.app')

@section('title')
    Itens disponíveis
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.premium_shoppings.index') }}"><span>Serviços premium</span></a></li>
    <li class="active"><span>Solicitar serviço premium</span></li>
@endsection

@section("wrapper")
    <form action="{{ route('customer.premium_shoppings.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Basic Table -->
            <div class="col-sm-8">
                <div class="card round-10 w-100">
                    <div class="card-body">
                        <h6>Itens disponíveis</h6>

                        <p class="text-muted">Escolha os produtos que deseja enviar.</p>
                        <div class="table-wrap mt-40">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mb-4">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Imagem</th>
                                                    <th>Código</th>
                                                    <th>Observação</th>
                                                    <th>Peso</th>
                                                    <th>Quantidade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $key => $row)
                                                    <tr class="align-middle">
                                                        <td class="text-center">
                                                            <input type="radio" name="package_item_id" value="{{ $row->id }}" class="item" data-amount="{{ $row->amount }}" required />
                                                        </td>
                                                        <td>
                                                            <a href="{{ asset('storage/package-items/'. $row->image) }}" data-fancybox="gallery" data-caption="{{ $row->sku }} - {{ $row->name }}">
                                                                <img src="{{ asset('storage/package-items/'. $row->image) }}" alt="Foto do pacote" width="50" />
                                                            </a>
                                                        </td>
                                                        <td>PROD{{ $row->id }}</td>
                                                        <td>{{ $row->description }}</td>
                                                        <td>{{ $row->weight }}</td>
                                                        <td>{{ $row->amount }}</td>
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
            </div>
            <div class="col-sm-4">
                <div class="card sticky-top round-10 w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="premium_service_id">Serviço Premium</label>
                                    <select required name="premium_service_id" id="premium_service_id" class="form-control form-select">
                                        <option value="">--escolha o serviço premium--</option>
                                        @foreach ($services as $key => $service)
                                            <option value="{{ $service->id }}" data-info="{{ collect($service)->only(['description', 'need_description', 'price']) }}">{{ $service->name }} ({{ $service->price ?? 'a definir' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 other_premium_service mt-3">
                                <div class="form-group">
                                    <label for="service_description_info">Descrição do serviço</label>
                                    <span class="border p-1 d-block border-rounded bg-light" id="service_description_info">escolha um serviço acima</span>
                                </div>
                            <div class="col-md-12 mt-3 d-none" id="need_description">
                                <div class="form-group">
                                    <label for="service_description">Descrição do serviço</label>
                                    <textarea required name="service_description" id="service_description" rows="5" class="form-control" placeholder="Descreva qual serviço você deseja, e vamos enviar para análise..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 my-3">
                                <div class="form-group">
                                    <label for="quantity">Quantidade</label>
                                    <input type="number" required min="1" max="1" class="form-control" name="quantity" id="quantity" />
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ URL::previous() }}" class="btn btn-light">
                                voltar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <span class="btn-text">Solicitar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Basic Table -->
        </div>
    </form>
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
    <script src="/js/customer/premium_shoppings/create.js"></script>
@endsection
