<div class="row">
    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-10 text-left" for="weight_min">Peso inicial</label>
        <input type="number" min="0" step="1" class="form-control" name="weight_min" id="weight_min" placeholder="Informe o peso inicial" value="{{ !empty($fee->weight_min) ? (int)$fee->weight_min : old('weight_min') }}" />
    </div>
    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-10 text-left" for="weight_max">Peso final</label>
        <input type="number" min="0" step="1" class="form-control" name="weight_max" id="weight_max" placeholder="Informe o peso final" value="{{ !empty($fee->weight_max) ? $fee->weight_max : old('weight_max') }}" />
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="value">Valor ($)</label>
        <input type="number" min="0" step="0.01" class="form-control" name="value" id="value" placeholder="Informe o valor da taxa" value="{{ !empty($fee->value) ? $fee->value : old('value') }}" />
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
