@extends('layouts.app')

@section('title')
    Detalhes do pedido de serviço premium
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('premium_shoppings.index') }}"><span>Pedidos de serviços premium</span></a></li>
    <li class="active"><span>Detalhes do pedido de serviço premium</span></li>
@endsection

@section('wrapper')
    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="card round-10 w-100">
                <div class="card-body">
                    <h6>Detalhes do pedido de serviço premium</h6>
                    
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-wrap mt-40">
                                    <p>
                                        <strong>N<sup>o</sup>: </strong>
                                        {{ $premium_shopping->id }}
                                    </p>
                                    <p>
                                        <strong>Data da solicitação: </strong>
                                        {{ $premium_shopping->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    <p>
                                        <strong>Cliente: </strong>
                                        {{ $premium_shopping->user->name }}
                                    </p>
                                    <p>
                                        <strong>Item: </strong>
                                        {{ $premium_shopping->package_item->description ?? '' }}
                                    </p>
                                    <p>
                                        <strong>Serviço contratado: </strong>
                                        {{ $premium_shopping->premium_service->name }}
                                    </p>
                                    <p>
                                        <strong>Valor:</strong>
                                        {{ !empty($premium_shopping->price) ? '$ '. $premium_shopping->price : 'a definir' }}
                                    </p>
                                    <p>
                                        <strong>Status: </strong>
                                        {{ $premium_shopping->status_text }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12 mt-40">
                                @if ((int)$premium_shopping->status < 3)
                                    <h3 class="mb-10">Dados da solicitação</h3>
                                    <form action="{{ route('premium_shoppings.update', ['premium_shopping' => $premium_shopping]) }}" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label for="status">Mudar status para:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value=""></option>
                                                @foreach ($status_options as $id => $name)
                                                    <option value="{{ $id }}" {{ (!empty($premium_shopping->status) && $premium_shopping->status == $id) ? 'selected="selected"' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="price">Valor do serviço:</label>
                                            <input type="number" {{ isset($premium_shopping->price) ? 'readonly' : '' }} min="0" step="0.01" name="price" id="price" class="form-control" value="{{ !empty($premium_shopping->price) ? number_format($premium_shopping->price, 2, '.', '') : old('price') }}" />
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="observation">Observações:</label>
                                            <textarea name="observation" id="observation" class="form-control" rows="5">{{ $premium_shopping->observation || old('observation') }}</textarea>
                                        </div>

                                        <div class="files">
                                            <div class="form-group mb-3 file-item">
                                                <label for="file-0">Arquivo:</label>
                                                <input type="file" name="files[]" id="file-0" class="form-control" />
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-4">
                                            <a href="#" class="btn-new-file btn-sm btn-light">
                                                <i class="bx bx-plus"></i> novo arquivo
                                            </a>
                                        </p>

                                        <hr />
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ URL::previous() }}" class="btn btn-light">
                                                voltar
                                            </a>

                                            <button type="submit" class="btn btn-success">
                                                <span class="btn-text">Atualizar</span>
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    @if (!empty($premium_shopping->files))
                                        <h4 class="mb-10">Arquivos</h4>

                                        <div class="list-group">
                                            @foreach ($premium_shopping->files as $file)
                                                <a href="{{ asset('storage/premium_shopping_files/'. $file->file) }}" target="_blank" class="list-group-item">
                                                    {{ $file->file }}
                                                </a>
                                            @endforeach
                                          </div>
                                    @endif
                                @endif
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
        $(function() {

            $('.btn-new-file').on('click', function(e) {
                e.preventDefault()

                const clone = $('.files').find('.file-item:first').clone()
                clone.find('input[type=file]').val('')
                
                $('.files').append(clone)
            })

        })
    </script>
@endsection
