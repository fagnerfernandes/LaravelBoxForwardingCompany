<div class="row">
    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="title">Nome do produto</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Nome do produto" value="{{ !empty($row->title) ? $row->title : old('title') }}" />
    </div>

    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="link">link</label>
        <input type="text" id="link" name="link" class="form-control" placeholder="Link para a compra" value="{{ !empty($row->link) ? $row->link : old('link') }}" />
    </div>

    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="color">Cor desejada</label>
        <input type="text" class="form-control" placeholder="Primeira opção de cor" id="color" name="color" value="{{ !empty($row->color) ? $row->color : old('color') }}" />
    </div>

    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="color_optional">Cor desejada (segunda opção)</label>
        <input type="text" class="form-control" placeholder="Segunda opção de cor" id="color_optional" name="color_optional" value="{{ !empty($row->color_optional) ? $row->color_optional : old('color_optional') }}" />
    </div>

    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="size">Tamanho desejado</label>
        <input type="text" class="form-control" placeholder="Primeira opção de Tamanho" id="size" name="size" value="{{ !empty($row->size) ? $row->size : old('size') }}" />
    </div>

    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="size_optional">Tamanho desejado (segunda opção)</label>
        <input type="text" class="form-control" placeholder="Segunda opção de Tamanho" id="size_optional" name="size_optional" value="{{ !empty($row->size_optional) ? $row->size_optional : old('size_optional') }}" />
    </div>

    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="price">Preço do produto</label>
        <input type="text" class="form-control" placeholder="Preço do produto" id="price" name="price" value="{{ !empty($row->price) ? $row->price : old('price') }}" />
    </div>

    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="quantity">Quantidade</label>
        <input type="text" class="form-control" placeholder="Quantidade" id="quantity" name="quantity" value="{{ !empty($row->quantity) ? $row->quantity : old('quantity') }}" />
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-1 text-left" for="observation">Observações</label>
        <textarea class="form-control" placeholder="Observações da compra" id="observation" name="observation" rows="5">{{ !empty($row->observation) ? $row->observation : old('observation') }}</textarea>
    </div>
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

