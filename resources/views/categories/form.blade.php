<div class="row">
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Informe o nome" value="{{ !empty($category->name) ? $category->name : old('name') }}" />
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


