<div class="row">
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="key">Nome</label>
        <input type="text" class="form-control" name="key" id="key" placeholder="Informe o nome da configuração" value="{{ !empty($setting->key) ? $setting->key : old('key') }}" />
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="value">Valor</label>
        <textarea class="form-control" name="value" id="value" placeholder="Informe o valor da configuração" rows="3">{{ !empty($setting->value) ? $setting->value : old('value') }}</textarea>
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="description">Descrição</label>
        <textarea class="form-control" name="description" id="description" placeholder="Informe a descrição da configuração (não obrigatório)" rows="5">{{ !empty($setting->description) ? $setting->description : old('description') }}</textarea>
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
