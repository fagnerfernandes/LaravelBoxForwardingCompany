<div class="form-group mb-3">
    <label class="control-label mb-10 text-left" for="name">Nome</label>
    <input type="text" class="form-control" placeholder="Nome do usuário" id="name" name="name" value="{{ !empty($row->name) ? $row->name : old('name') }}" />
</div>
<div class="form-group mb-3">
    <label class="control-label mb-10 text-left" for="email">Email</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="Email do usuário" value="{{ !empty($row->email) ? $row->email : old('email') }}" />
</div>
<div class="form-group mb-3">
    <label class="control-label mb-10 text-left" for="password">Senha</label>
    <input type="password" class="form-control" value="" name="password" id="password" placeholder="Senha de acesso" />
</div>
<div class="form-group mb-3">
    <label class="control-label mb-10 text-left" for="password_confirmation">Confirmar Senha</label>
    <input type="password" class="form-control" value="" name="password_confirmation" id="password_confirmation" placeholder="Confirmar senha de acesso" />
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