<div class="row mb-2">
    @if ($editing)
        <input type="hidden" name="user_id" value="{{ $customer->user->id }}">
        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
    @endif
    <div class="col-md-12 form-group mb-3 {{ $errors->has('user.name') ? 'has-error' : ''}}">
        <label for="user.name" class="control-label">{{ 'Nome' }}</label>
        <input class="form-control" name="user[name]" type="text" id="user.name" value="{{ isset($customer->user->name) ? $customer->user->name : old('user.name')}}" >
        {!! $errors->first('user.name', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-4 form-group mb-3 {{ $errors->has('user.email') ? 'has-error' : ''}}">
        <label for="user.email" class="control-label">{{ 'Email' }}</label>
        <input class="form-control" name="user[email]" type="text" id="user.email" value="{{ isset($customer->user->email) ? $customer->user->email : old('user.email')}}" >
        {!! $errors->first('user.email', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-4 form-group mb-3 {{ $errors->has('document') ? 'has-error' : ''}}">
        <label for="document" class="control-label">{{ 'CPF' }}</label>
        <input class="form-control cpf" name="document" type="text" id="document" value="{{ isset($customer->document) ? $customer->document : old('document')}}" >
        {!! $errors->first('document', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" col-md-4 form-group mb-3 {{ $errors->has('suite') ? 'has-error' : ''}}">
        <label for="suite" class="control-label">{{ 'Suite' }}</label>
        <input class="form-control" name="suite" type="text" id="suite" value="{{ isset($customer->suite) ? $customer->suite : old('suite')}}" >
        {!! $errors->first('suite', '<p class="help-block">:message</p>') !!}
    </div>

    @if (!$editing)
    <div class=" col-md-4 form-group mb-3 {{ $errors->has('password') ? 'has-error' : ''}}">
        <label for="password" class="control-label">{{ 'Senha' }}</label>
        <input class="form-control" name="user[password]" type="password" id="password" value="" >
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" col-md-4 form-group mb-3 {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
        <label for="password_confirmation" class="control-label">{{ 'Confirmação da senha' }}</label>
        <input class="form-control" name="user[password_confirmation]" type="password" id="password_confirmation" value="" >
        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
    </div>
    @endif


</div>
<div class="mb-4">
    <label>
        <input type="hidden" name="active" value="0" />
        <input type="checkbox" name="active" value="1" {{ (!empty($customer->active) && (bool)$customer->active) ? 'checked="checked"' : '' }} /> Ativo
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