@inject('packageModel', 'App\Models\Package')
@inject('packageItemModel', 'App\Models\PackageItem')
@inject('shippingModel', 'App\Models\Shipping')
@inject('affiliateModel', 'App\Models\Affiliate')

@extends("layouts.app")

@section("wrapper")
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('img/me.png') }}" alt="Admin" class="rounded-circle p-1 bg-primary img-fluid img-thumbnail" style="width: 128px; height: 128px; object-fit: cover">
                        <div class="mt-3">
                            <h4 class="fs-6 fw-bolder text-primary">{{ auth()->user()->name }}</h4>
                            <p class="font-size-sm d-block text-primary">
                                <span class="bg-primary text-white p-1 rounded">#{{ auth()->user()->userable->suite }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="my-3"></div>
                    <h5 class="fs-6 text-center text-primary fw-bold">Seu endereço na américa é:</h5>
                    <hr>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p class="p-0 m-0">
                                <strong class="text-primary">Nome: </strong>{{ auth()->user()->name }}
                            </p>
                            <p class="p-0 m-0">
                                <strong class="text-primary">Endereço: </strong>ADDRESS Suite {{ auth()->user()->userable->suite }}
                            </p>
                            <p class="p-0 m-0">
                                <strong class="text-primary">Cidade: </strong>CITY
                            </p>
                            <p class="p-0 m-0">
                                <strong class="text-primary">Estado: </strong>STATE
                            </p>
                            <p class="p-0 m-0">
                                <strong class="text-primary">CEP (Zipcode): </strong>ZIP
                            </p>
                            <p class="p-0 m-0">
                                <strong class="text-primary">País: </strong>United State
                            </p>
                            <p class="p-0 m-0">
                                <strong class="text-primary">Telefone: </strong>+1 (000) 000.0000
                            </p>
                        </li>
                        <li class="list-group-item d-flex justify-content-center align-items-center flex-wrap">
                            <h6 class="mb-2 text-center fw-bolder fs-5">Importante:</h6>
                            <p class="text-center">
                                Sempre que preencher seu endereço, inclua o número de sua suíte. Essa informação
                                é indispensável para localizarmos suas encomendas.
                            </p>
                        </li>
                        <li class="list-group-item d-flex justify-content-center align-items-center flex-wrap">
                            <div class="d-grid gap-0">
                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalSendRules">VER REGRAS DE ENVIO</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col">
                    <a href="{{ route('customer.credits.index') }}">
                        <div class="card py-2 radius-10 overflow-hidden bg-gradient-Ohhappiness">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white"><small>Carteira</small></p>
                                        <h5 class="mb-0 text-white">@currency(auth()->user()->creditBalance())</h5>
                                    </div>
                                    <div class="ms-auto text-white">
                                        <i class="bx bx-wallet font-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('customer.affiliates.index') }}">
                        <div class="card radius-10 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-2 fw-bolder">Meus afiliados</p>
                                        {{-- @php($indicates = $affiliateModel->where('who_indicate_id', auth()->user()->userable_id)->count()) --}}
                                        <h5 class="mb-0 fs-6">{{ Auth::user()->userable->affiliates()->count() }} cadastrados</h5>
                                    </div>
                                    <div class="ms-auto">
                                        <i class="bx bx-user font-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('customer.packages.index') }}">
                        <div class="card py-2 radius-10 overflow-hidden bg-gradient-cosmic">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white"><small>Pacotes recebidos</small></p>
                                        <h5 class="mb-0 text-white">{{ $packageModel->count() }}</h5>
                                    </div>
                                    <div class="ms-auto text-white">
                                        <i class="bx bx-package font-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div class="card radius-10 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-2 fw-bolder">Carteira Afiliados</p>
                                    <h5 class="mb-0 fs-6">$ 0.00</h5>
                                </div>
                                <div class="ms-auto">
                                    <i class="bx bxs-wallet font-30"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <a href="{{ route('customer.items.available') }}">
                        <div class="card py-2 radius-10 overflow-hidden bg-gradient-moonlit">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white"><small>Produtos em estoque</small></p>
                                        <h5 class="mb-0 text-white">{{ $packageItemModel->count() }}</h5>
                                    </div>
                                    <div class="ms-auto text-white">
                                        <i class="bx bx-qr font-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('customer.shippings.index') }}">
                        <div class="card radius-10 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-2 fw-bolder">Meus envios</p>
                                        <h5 class="mb-0 fs-6">{{ $shippingModel->count() }}</h5>
                                    </div>
                                    <div class="ms-auto">
                                        <i class="bx bxs-send font-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-2 fw-bolder">Link para afiliados</p>
                            <div class="input-group">
                                <div class="text-primary form-control">
                                    {{ env('APP_URL') }}/register?af={{ auth()->user()->userable->affiliate_token ?? '' }}
                                </div>
                                <button class="btn btn-outline-primary" id="btnCopyClipboard" data-clipboard-text='{{ route('register', ['af' => auth()->user()->userable->affiliate_token]) }}' title="Copiar Link de Afiliados"><i class='bx bx-copy' style="margin-right: 0px;"></i></a>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <a class="fs-1" id="btnShareWhatsapp" data-url="{{ 'https://api.whatsapp.com/send?text='.route('register', ['af' => auth()->user()->userable->affiliate_token ?? '']) }}" data-text="Compartilhar no Whatsapp" data-bs-toggle="modal" data-bs-target="#linkAfiliados"><i class="bx bxl-whatsapp"></i></a>
                            <a class="fs-1" data-url="{{ 'https://www.facebook.com/sharer/sharer.php?u='.route('register', ['af' => auth()->user()->userable->affiliate_token ?? '']) }}" data-bs-toggle="modal" data-text="Compartilhar no Facebook" data-bs-target="#linkAfiliados"><i class="bx bxl-facebook-circle"></i></a>
                            {{-- <a class="fs-1" data-url="{{ route('register', ['af' => auth()->user()->userable->affiliate_token ?? '']) }}" data-bs-toggle="modal" data-text="Compartilhar no Instagram (Copiar Link)" data-bs-target="#linkAfiliados"><i class="bx bxl-instagram"></i></a>
                            <a class="fs-1" data-url="{{ route('register', ['af' => auth()->user()->userable->affiliate_token ?? '']) }}" data-bs-toggle="modal" data-text="Compartilhar no Twitter (Copiar Link)" data-bs-target="#linkAfiliados"><i class="bx bxl-twitter"></i></a> --}}
                            <a class="fs-1" data-url="{{ 'https://www.linkedin.com/shareArticle?mini=true&url='.route('register', ['af' => auth()->user()->userable->affiliate_token ?? '']) }}" data-bs-toggle="modal" data-text="Compartilhar no Linkedin" data-bs-target="#linkAfiliados"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card radius-10 overflow-hidden py-4">
                        <div class="card-body my-4 py-4">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <p class="mb-2 fw-bolder">Banner de imagem / vídeo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 overflow-hidden py-4">
                        <div class="card-body my-4 py-4">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <p class="mb-2 fw-bolder">Banner de imagem / vídeo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    @include('dashboard.copy-confirmation-modal', ['message' => 'Código de Afiliados copiado com sucesso!'])
    {{-- Modal de regras de envio --}}
    {{-- <div class="modal fade" id="modalSendRules" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
    <div class="modal fade show" id="modalSendRules" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Regras de envio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Quais itens são proibidos e não podem ser entregues pela Company?
                    </p>
                    <p>
                        Embora os itens proibidos variem de acordo com o país, em nenhum caso podemos enviar internacionalmente os seguintes itens:
                    </p>
                    <ul>
                        <li>Materiais perigosos (fósforos, produtos químicos, explosivos)</li>
                        <li>Armas, peças, munições, facas e miras</li>
                        <li>Baterias (as baterias dentro de telefones celulares ou laptops estão OK)</li>
                        <li>Materiais combustíveis / inflamáveis ​​(tintas, óleos, esmaltes, perfumes, fragrâncias, laca, isqueiros e outros produtos inflamáveis)</li>
                        <li>Animais (Répteis devem ser enviados em embalagens aprovadas por revendedor especializado)</li>
                        <li>Barra de ouro</li>
                        <li>Moeda</li>
                        <li>Drogas / Narcóticos</li>
                        <li>Tabaco</li>
                        <li>Produtos radioativos</li>
                    </ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendi</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
    @include('customer.users.modal-link-afiliados');
@endsection

@push('bottom-scripts')
    <script src="https://unpkg.com/clipboard@2/dist/clipboard.min.js"></script>
    <script>
        $(() => {
            $(document).on('show.bs.modal', '#linkAfiliados', (e) => {
                let btn = $(e.relatedTarget).closest('a')[0]; // Button that triggered 
                let url = btn.dataset['url']
                let text = btn.dataset['text']
                $('#modalUrlLink').prop('href', url);
                $('#modalUrlLink').html(text);
            });
        })
    </script>
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
@endpush
