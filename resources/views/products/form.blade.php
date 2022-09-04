<div class="row">
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="category_id">Categoria</label>
        <select class="form-control" name="category_id" id="category_id">
            <option value="">--escolha a categoria--</option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" {{ (!empty($product->category_id) && $product->category_id == $id) ? 'selected="selected"' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-3 col-md-4">
        <label class="control-label mb-10 text-left" for="code">Código</label>
        <input type="text" class="form-control" name="code" id="code" placeholder="Informe o código" value="{{ !empty($product->code) ? $product->code : old('code') }}" />
    </div>
    <div class="form-group mb-3 col-md-8">
        <label class="control-label mb-10 text-left" for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Informe o nome" value="{{ !empty($product->name) ? $product->name : old('name') }}" />
    </div>
    <div class="form-group mb-3 col-md-4">
        <label class="control-label mb-10 text-left" for="price">Valor</label>
        <input type="number" min="0" step="0.01" class="form-control" name="price" id="price" placeholder="Informe o preço do produto" value="{{ !empty($product->price) ? $product->price : old('price') }}" />
    </div>
    <div class="form-group mb-3 col-md-4">
        <label class="control-label mb-10 text-left" for="promotional_price">Valor promocional</label>
        <input type="number" min="0" step="0.01" class="form-control" name="promotional_price" id="promotional_price" placeholder="Informe o preço promocional do produto" value="{{ !empty($product->promotional_price) ? $product->promotional_price : old('promotional_price') }}" />
    </div>
    <div class="form-group mb-3 col-md-4">
        <label class="control-label mb-10 text-left" for="weight">Peso</label>
        <input type="number" min="0" step="0.01" class="form-control" name="weight" id="weight" placeholder="Informe o preço promocional do produto" value="{{ !empty($product->weight) ? $product->weight : old('weight') }}" />
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="description">Descrição</label>
        <textarea class="form-control" name="description" id="description" placeholder="Informe a descrição do produto (não obrigatório)" rows="5">{{ !empty($setting->description) ? $setting->description : old('description') }}</textarea>
    </div>

    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="amount">Estoque atual</label>
        <input {{ !str_contains(request()->path(), 'create') ? 'readonly' : '' }} type="number" min="0" step="1" class="form-control" name="amount" id="amount" placeholder="Informe o estoque atual" value="{{ !empty($product->amount) ? $product->amount : old('amount') }}" />
    </div>
</div>

<div class="mb-3">
    <input type="hidden" name="active" value="0" />
    <label>
        <input type="checkbox" name="active" value="1" {{ (!empty($product->active) && (bool)$product->active) ? 'checked="checked"' : '' }} /> Ativo
    </label>
</div>

<div class=" mb-3">
    <input type="hidden" name="shipping_included" value="0" />
    <label>
        <input type="checkbox" name="shipping_included" value="1" {{ (!empty($product->shipping_included) && (bool)$product->shipping_included) ? 'checked="checked"' : '' }} /> Frete incluso
    </label>
</div>

<br />

<hr />
<div class="d-flex justify-content-between align-items-center">
    <a href="{{ URL::previous() }}" class="btn btn-light">
        voltar
    </a>
    <button type="submit" class="btn btn-success">
        <span class="btn-text">Gravar</span>
    </button>
</div>


