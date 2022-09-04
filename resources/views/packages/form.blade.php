<div class="form-group mb-3">
    <label class="control-label mb-1 text-left" for="suite">Suite</label>
    <select name="customer_id" id="customer_id" class="form-control">
        @if(isset($customer) && !empty($customer))
            <option value="{{ $customer->id }}" selected="selected">{{ $customer->userable->suite .' - '. $customer->name }}</option>
        @else
            <option value=""></option>
        @endif
    </select>
</div>

<div class="form-group mb-3">
    <label class="control-label mb-1 text-left" for="tracking_code">Código de rastreio</label>
    <input type="text" id="tracking_code" name="tracking_code" class="form-control" placeholder="Digite o código de rastreio" value="{{ !empty($row->tracking_code) ? $row->tracking_code : old('tracking_code') }}" />
</div>

<div class="form-group mb-3">
    <label class="control-label mb-1 text-left" for="location">Localização do pacote</label>
    <input type="text" id="location" name="location" class="form-control" placeholder="Localização do pacote" value="{{ !empty($row->location) ? $row->location : old('location') }}" />
</div>

<div class="form-group mb-3">
    <label class="control-label mb-1 text-left" for="name">Observação</label>
    <input type="text" class="form-control" placeholder="Observação do pacote" id="name" name="name" value="{{ !empty($row->name) ? $row->name : old('name') }}" />
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label class="control-label mb-1 text-left" for="photo">Upload de foto do pacote</label>
            <input type="file" class="form-control" name="photo" id="photo_gallery" placeholder="Foto do Pacote" />
        </div>
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

@if (!empty($row->photo))
    <p class="mb-5">
        <img src="{{ asset('/storage/packages/'. $row->photo) }}" alt="Foto" width="300" />
    </p>
@endif

<hr>
<div class="d-flex justify-content-between align-items-center">

    <a href="{{ URL::previous() }}" class="btn btn-light">
        voltar
    </a>

    <div>
        <button type="submit" name="next" class="btn btn-light" value="mais_um">
            <span class="btn-text">Gravar e adicionar próximo</span>
        </button>
        <button name="next" type="submit" class="btn btn-light" value="add_items">
            <span class="btn-text">Gravar e adicionar itens</span>
        </button>
        <button name="next" type="submit" class="btn btn-success" value="finish">
            <span class="btn-text">Gravar</span>
        </button>
    </div>
</div>

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#customer_id').select2({
            width: 'resolve',
            theme: 'classic',
            ajax: {
                delay: 250,
                url: function(params) {
                    return '/customers/search?search='+ params.term;
                },
                processResults: function(data) {
                    return {
                        results: data.items,
                        // pagination: {
                        //     more: true
                        // }
                    }
                },
                cache: true
            },
        })

        document.addEventListener('DOMContentLoaded', () => {

            // let showCameraCanvas = false

            // let camera_button = document.querySelector('#start-camera')
            // let video = document.querySelector('#video')
            // let click_button = document.querySelector('#click-photo')
            // let canvas = document.querySelector('#canvas')

            // const cameraOptions = {
            //     video: {
            //         min: 1280,
            //         ideal: 1920,
            //         max: 2560,
            //     },
            //     audio: false,
            //     height: {
            //         min: 720,
            //         ideal: 1080,
            //         max: 1440,
            //     }
            // }

            // camera_button.addEventListener('click', async () => {
            //     document.querySelector('#camera-box').classList.remove('hide')
            //     // let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            //     let stream = await navigator.mediaDevices.getUserMedia(cameraOptions)
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

