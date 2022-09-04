<div class="row">
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-1 text-left" for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Informe o nome" value="{{ !empty($extra_service->name) ? $extra_service->name : old('name') }}" />
    </div>
    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="price">Preço</label>
        <input type="text" class="form-control price" name="price" id="price" placeholder="Informe o preço do serviço" value="{{ !empty($extra_service->price) ? $extra_service->price : old('price') }}" />
    </div>
    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-1 text-left" for="weight">Peso</label>
        <input type="number" min="0" step="0.01" class="form-control" name="weight" id="weight" placeholder="Informe o peso que o serviço adiciona ao pacote" value="{{ !empty($extra_service->weight) ? $extra_service->weight : old('weight') }}" />
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-1 text-left" for="description">Descrição</label>
        <textarea class="form-control" name="description" id="description" placeholder="Informe a descrição do produto (não obrigatório)" rows="5">{{ !empty($extra_service->description) ? $extra_service->description : old('description') }}</textarea>
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

