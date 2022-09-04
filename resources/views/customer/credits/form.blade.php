<div class="row">
    <div class="form-group col-md-12 mb-3">
        <label class="control-label mb-2 text-left" for="amount">Valor que deseja adicionar</label>
        <input type="number" min="1" step="0.01" class="form-control" name="amount" id="amount" placeholder="Informe quanto deseja adicionar de crédito" inputmode="numeric" />
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
