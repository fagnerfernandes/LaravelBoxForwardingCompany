@extends('layouts.app')

@section('title')
    Imagens do Produto <small># {{ $product->code .' - '. $product->name }}</small>
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('products.index') }}">Produtos</a></li>
    <li class="active"><span>Imagens do Produto <small># {{ $product->code .' - '. $product->name }}</small></span></li>
@endsection

@section('wrapper')
<div class="row">
    <!-- Basic Table -->
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="pull-left">
                    <h4 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Imagens do Produto <small># {{ $product->code .' - '. $product->name }}</small></h4>
                </div>
            </div>
            <div class="card-body">
                <div class="panel-body">
                    {{-- <p class="text-muted">Add class <code>table</code> in table tag.</p> --}}
                    <div class="table-wrap mt-40">

                        <p>
                            <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                            <div id="fileuploader">Escolha as imagens</div>
                        </p>
                        
                        {{-- Lista de Imagens do produto --}}
                        <div class="row" id="image-list">
                            @foreach ($rows as $img)
                                <div class="col-md-4 col-lg-3 mb-3 image-item" style="margin-bottom: 2rem;" id="img-{{ $img->id }}">
                                    <div class="card card-default text-center mx-auto" style="border: 1px solid #ccc; padding: 10px;">
                                        <img src="{{ asset('storage/products/'. $img->image) }}" style="width:100%; height: 200px; object-fit: contain" class="card-img-top" />
                                        <div class="card-body">
                                            <div class="btn-group p-2" role="group">
                                                <div class="d-block">
                                                    <form method="POST" action="{{ url("/product-images/{$img->id}") }}" style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Remover imagem" onclick="return confirm(&quot;Você tem certeza?&quot;)">Remover Imagem <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Basic Table -->
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="//hayageek.github.io/jQuery-Upload-File/4.0.6/uploadfile.css">
@endsection

@section('scripts')
    <script src="//hayageek.github.io/jQuery-Upload-File/4.0.6/jquery.uploadfile.min.js"></script>
    <script src="{{ asset('/js/product_images/index.js') }}"></script>
@endsection