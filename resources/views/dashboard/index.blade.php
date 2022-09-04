@extends('layouts.app')

@section("wrapper")
    <div class="row mt-20">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="card-header">
                    Últimas solicitações de envio
                </div>
                <div class="panel-body">

                    <div class="list-group">
                        @foreach ($shippings as $shipping)
                            <a href="#" class="list-group-item  my-0 py-0">
                                <span class="badge">{{ $shipping->created_at->format('d/m/Y H:i') }}</span>
                                <h6 class="list-group-item-heading my-0 py-0">
                                    #{{ $shipping->id }} -
                                    {{ $shipping->user->name ?? '' }}
                                </h6>
                                <p class="list-group-item-text py-0">
                                    <small>Status: </small>{{ $shipping->status_text }}
                                </p>
                            </a>
                        @endforeach
                    </div>

                    <p class="text-right">
                        <a href="{{ url('/shippings') }}" class="">ver todas as solicitações</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="card-header">
                    Últimos clientes cadastrados
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        @foreach ($customers as $customer)
                            <a href="#" class="list-group-item my-0 py-0">
                                <span class="badge">{{ $customer->created_at->format('d/m/Y H:i') }}</span>
                                <h6 class="list-group-item-heading my-0 py-0">
                                    #{{ $customer->user->name ?? '' }}
                                </h6>
                                <p class="list-group-item-text py-0">
                                    <small>E-mail: </small>{{ $customer->user->email ?? '' }}
                                </p>
                            </a>
                        @endforeach
                    </div>

                    <p class="text-right">
                        <a href="{{ url('/customers') }}" class="">ver todas as solicitações</a>
                    </p>
                </div>
            </div>
        </div>
    </div>   
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6>Código para iFrame de Calculadora de Frete</h6>
                        <a class="btn btn-outline-primary" id="btnCopyClipboard" data-clipboard-text='<iframe src="{{ route('shipping.calc') }}" width="100%" height="650px" style="border:none;"></iframe>' title="Copiar iFrame"><i class='bx bx-copy'></i> Copiar Código Fonte</a>
                    </div>
                </div>
                <div class="card-body">
                    <iframe src="{{ route('shipping.calc') }}" width="100%" height="650px" style="border:none;"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('dashboard.copy-confirmation-modal', ['message' => 'Código para aplicação do iFrame copiado com sucesso!'])

@section('scripts')
    <script src="https://unpkg.com/clipboard@2/dist/clipboard.min.js"></script>
    <script>
        $(() => {
            /* $('#btnCopyClipboard').on('click', (e) => {
                navigator.clipboard.writeText(e.target.closest('a').dataset.url);
                $('#modalCopyIframe').modal('show');
            }); */
            new ClipboardJS('#btnCopyClipboard').on('success', (e) => {
                $('#modalCopyIframe').modal('show');
            })
        }) 
    </script>
@endsection
