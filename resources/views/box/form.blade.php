<div class="row">
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="key">Nome</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Informe o nome da CAIXA" value="{{ !empty($box->name) ? $box->name : old('name') }}" required/>
    </div>
    <div class="form-group mb-3 col-md-4">
        <label class="control-label mb-1 text-left" for="depth">Profundidade</label>
        <input type="text" class="form-control depth" name="depth" id="depth" placeholder="Informe a Profundidade" value="{{ !empty($box->depth) ? $box->depth : old('depth') }}" required/>
    </div>

    <div class="form-group mb-3 col-md-4">
        <label class="control-label mb-1 text-left" for="width">Largura</label>
        <input type="text" class="form-control width" name="width" id="width" placeholder="Informe a Largura" value="{{ !empty($box->width) ? $box->width : old('width') }}" required/>
    </div>

    <div class="form-group mb-3 col-md-4">
        <label class="control-label mb-1 text-left" for="height">Altura</label>
        <input type="text" class="form-control height" name="height" id="height" placeholder="Informe a Altura" value="{{ !empty($box->height) ? $box->height : old('height') }}" required/>
    </div>

    <div class="form-group mb-3 col-md-12">
        Peso máximo - 66 lbs <br />
        Tamanho máximo - (Profundidade + Largura + Altura) até 78" (198cm) Comprimento até 40" (101cm)<br />
        Valor máximo declarado - U$ 1000,00
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
