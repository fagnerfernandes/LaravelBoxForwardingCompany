@extends('layouts.app')

@section('title')
    Adicionar item do Pacote
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('packages.index') }}">Pacotes</a></li>
    <li><a href="{{ route('package-items.index', ['package_id' => $package->id]) }}">Itens do pacote</a></li>
    <li class="active"><span>Adicionar item</span></li>
@endsection

@section('wrapper')
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-header">
                    <h6 class="panel-title txt-dark">Adicionar item do pacote</h6>
                </div>
                <div class="card-body">
                    <div class="panel-body">
                        {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                        <div class="table-wrap mt-40">
                            <div class="form-wrap">
                                <form action="{{ route('package-items.store', ['package_id' => $package->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        {{--<div class="form-group mb-3 col-md-3">
                                            <label class="control-label mb-10 text-left" for="reference">SKU</label>
                                            <input type="text" class="form-control" name="reference" id="reference" placeholder="SKU do item" value="{{ old('reference') }}" />
                                        </div>--}}
                                        <div class="form-group mb-3 col-md-4">
                                            <label class="control-label mb-10 text-left" for="description">Nome</label>
                                            <input type="text" class="form-control" placeholder="Nome do pacote" id="description" name="description" value="{{ old('description') }}" />
                                        </div>

                                        <div class="form-group mb-3 col-md-4">
                                            <label class="control-label mb-10 text-left" for="weight">Peso (libras)</label>
                                            <input type="number" min="0.01" step="0.01" id="weight" name="weight" class="form-control" placeholder="Peso do item" value="{{ old('weight') }}" />
                                        </div>

                                        <div class="form-group mb-3 col-md-4">
                                            <label class="control-label mb-10 text-left" for="amount">Quantidade</label>
                                            <input type="number" min="1" id="amount" name="amount" class="form-control" placeholder="Quantidade" value="{{ old('amount') }}" />
                                        </div>

                                        <div class="form-group mb-3 col-md-12">
                                            <label class="control-label mb-10 text-left" for="image">Foto do item</label>
                                            <input type="file" class="form-control" name="image" id="image" placeholder="Foto do item" />
                                            @if (!empty($row->photo))
                                                <p class="mb-5">
                                                    <img src="{{ asset('/storage/package-items/'. $row->photo) }}" alt="Foto" width="300" />
                                                </p>
                                            @endif
                                        </div>

                                        {{-- <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="control-label mb-1 text-left" for="photo">Tirar foto do pacote</label>
                                                <div class="form-control">
                                                    <button type="button" class="btn btn-sm btn-light" id="start-camera">
                                                        <i class="zmdi zmdi-camera-add"></i> Capturar imagem via camera
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="camera-box d-none" id="camera-box" style="padding: 0.1rem">
                                                <div class="row">
                                                    <div class="col-md-6 text-center" style="">
                                                        <video id="video" width="100%" height="440" autoplay></video>
                                                        <p>
                                                            <button type="button" id="click-photo" class="btn btn-dark btn-sm">Tirar foto</button>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 text-center" style="">
                                                        <canvas id="canvas" style="width: 100%;" height="200"></canvas>
                                                        <input type="hidden" name="photo" id="photo_camera" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>

                                    <hr />
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ URL::previous() }}" class="btn btn-light">
                                            voltar
                                        </a>

                                        <button type="submit" class="btn btn-success">
                                            <span class="btn-text">Gravar</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // let showCameraCanvas = false

            // let camera_button = document.querySelector('#start-camera')
            // let video = document.querySelector('#video')
            // let click_button = document.querySelector('#click-photo')
            // let canvas = document.querySelector('#canvas')

            // camera_button.addEventListener('click', async () => {
            //     document.querySelector('#camera-box').classList.remove('hide')
            //     let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            //     video.srcObject = stream

            //     showCameraCanvas = !showCameraCanvas
            //     if (showCameraCanvas) {
            //         document.querySelector('#camera-box').classList.remove('d-none')
            //     } else document.querySelector('#camera-box').classList.add('d-none')
            // })

            // click_button.addEventListener('click', () => {
            //     canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height)
            //     let image_data_url = canvas.toDataURL('image/jpeg')

            //     console.log('Image', image_data_url)

            //     document.querySelector('input[name=photo]').value = image_data_url

            //     console.log('imagem', image_data_url)
            // })
        })
    </script>
@endsection
