<div class="row">
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Informe o nome" value="{{ !empty($premium_service->name) ? $premium_service->name : old('name') }}" />
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="price">Valor</label>
        <input type="number" min="0" step="0.01" class="form-control" name="price" id="price" placeholder="Informe o preço da serviço premium" value="{{ !empty($premium_service->price) ? $premium_service->price : old('price') }}" />
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="description">Descrição</label>
        <textarea class="form-control" name="description" id="description" placeholder="Informe a descrição do produto (não obrigatório)" rows="5">{{ !empty($premium_service->description) ? $premium_service->description : old('description') }}</textarea>
    </div>
</div>

<div class="mb-4">
    <input type="hidden" name="need_description" value="0" />
    <label>
        <input type="checkbox" name="need_description" value="1" {{ (!empty($premium_service->need_description) && (bool)$premium_service->need_description) ? 'checked="checked"' : '' }} /> Cliente precisa descrever o serviço
    </label>
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

