<div class="row">
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Nome do endereço (Casa, Trabalho, ...)" value="{{ !empty($row->name) ? $row->name : old('name') }}" />
    </div>
    <div class="form-group mb-3 col-md-3">
        <label class="control-label mb-10 text-left" for="postal_code">CEP</label>
        <input type="text" class="form-control cep" name="postal_code" id="postal_code" placeholder="CEP" value="{{ !empty($row->postal_code) ? $row->postal_code : old('postal_code') }}" />
    </div>
    <div class="form-group mb-3 col-md-6">
        <label class="control-label mb-10 text-left" for="street">Logradouro</label>
        <input type="text" id="street" name="street" class="form-control" placeholder="Logradouro" value="{{ !empty($row->street) ? $row->street : old('street') }}" />
    </div>
    <div class="form-group mb-3 col-md-3">
        <label class="control-label mb-10 text-left" for="number">Número</label>
        <input type="text" class="form-control" placeholder="Número" id="number" name="number" value="{{ !empty($row->number) ? $row->number : old('number') }}" />
    </div>
    <div class="form-group mb-3 col-md-3">
        <label class="control-label mb-10 text-left" for="complement">Complemento</label>
        <input type="text" class="form-control" name="complement" id="complement" placeholder=Complemento" value="{{ !empty($row->complement) ? $row->complement : old('complement') }}" />
    </div>
    <div class="form-group mb-3 col-md-3">
        <label class="control-label mb-10 text-left" for="district">Bairro</label>
        <input type="text" class="form-control" name="district" id="district" placeholder=Bairro" value="{{ !empty($row->district) ? $row->district : old('district') }}" />
    </div>
    <div class="form-group mb-3 col-md-3">
        <label class="control-label mb-10 text-left" for="city">Cidade</label>
        <input type="text" class="form-control" name="city" id="city" placeholder=Cidade" value="{{ !empty($row->city) ? $row->city : old('city') }}" />
    </div>
    <div class="form-group mb-3 col-md-3">
        <label class="control-label mb-10 text-left" for="state">Estado (UF)</label>
        <input type="text" class="form-control" name="state" id="state" maxlength="2" placeholder=Estado (UF)" value="{{ !empty($row->state) ? $row->state : old('state') }}" />
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

@section('scripts')
    <script src="{{ asset('js/addresses/form.js') }}"></script>
@endsection 