<div class="row">
    <div class="form-group col-md-12 mb-3">
        <label class="control-label mb-10 text-left" for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Informe o nome do tipo de declaração" value="{{ !empty($declaration_type->name) ? $declaration_type->name : old(' name') }}" />
    </div>
    <div class="form-group col-md-12 mb-3">
        <label class="control-label mb-10 text-left" for="family_product_skypostal">Family Product Skypostal</label>
        <input type="text" class="form-control" name="family_product_skypostal" id="family_product_skypostal" placeholder="Informe o Family Product Skypostal" value="{{ !empty($declaration_type->family_product_skypostal) ? $declaration_type->family_product_skypostal : old(' family_product_skypostal') }}" />
    </div>
    <div class="form-group col-md-12 mb-3">
        <label class="control-label mb-10 text-left" for="hs_code_skypostal">Hs Code Skypostal</label>
        <input type="text" class="form-control" name="hs_code_skypostal" id="hs_code_skypostal" placeholder="Informe o Hs Code Skypostal" value="{{ !empty($declaration_type->hs_code_skypostal) ? $declaration_type->hs_code_skypostal : old(' hs_code_skypostal') }}" />
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

