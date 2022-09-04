<div class="form-group mb-3 {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Nome' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($shop->name) ? $shop->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group mb-3 {{ $errors->has('link') ? 'has-error' : ''}}">
    <label for="link" class="control-label">{{ 'Link' }}</label>
    <input class="form-control" name="link" type="text" id="link" value="{{ isset($shop->link) ? $shop->link : ''}}" >
    {!! $errors->first('link', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group mb-3 {{ $errors->has('logo') ? 'has-error' : ''}}">
    <label for="logo" class="control-label">{{ 'Logo' }}</label>
    <input class="form-control" type="file" name="logo" />
    {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}
</div>
@if (!empty($shop->logo))
    <p>
        <img src="{{ asset('storage/shops/'. $shop->logo) }}" alt="Logo" width="100" height="100" style="object-fit: cover" />
    </p>
@endif

<div class="form-group mb-3 {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Descrição' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ isset($shop->description) ? $shop->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group mb-3 {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select class="form-control form-select" name="status" id="status" >
        <option value=""></option>
        <option value="R" {{ (!empty($shop->status) && $shop->status == 'R') ? 'selected="selected"' : '' }}>Recomendada</option>
        <option value="F" {{ (!empty($shop->status) && $shop->status == 'F') ? 'selected="selected"' : '' }}>Não Recomendada</option>
    </select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
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
