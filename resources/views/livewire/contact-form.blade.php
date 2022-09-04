<div class="row">
    <div class="col-sm-12">
        @if($success)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Mensagem enviada com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
        @endif
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark"><i class="zmdi zmdi-settings"></i> Entre em contato</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <div class="panel-body">
                    <div class="form-wrap">
                        <form wire:submit.prevent="sendMessage">
                            @csrf
                            <div class="row">
                                {{-- <div class="form-group mb-3 col-md-8">
                                    <label class="control-label mb-10 text-left" for="name">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Informe seu nome" wire:model.lasy="name" />

                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <input type="hidden" name="name" id="name" wire:model="name">
                                <input type="hidden" class="form-control" name="email" id="email" wire:model="email" />
                                <input type="hidden" class="form-control" name="phone" id="phone" wire:model="phone" />
                                {{-- <div class="form-group mb-3 col-md-4">
                                    <label class="control-label mb-10 text-left" for="email">E-mail</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text">
                                            <i class='bx bx-envelope'></i>
                                        </span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Informe seu E-mail" wire:model.lasy="email" />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                </div> --}}
                                {{-- <div class="form-group mb-3 col-md-4">
                                    <label class="control-label mb-10 text-left" for="phone">Telefone</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text">
                                            <i class='bx bx-phone'></i>
                                        </span>
                                        <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Informe o seu Telefone" wire:model.lasy="phone" />
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="form-group mb-3 col-md-6">
                                    <label class="control-label mb-10 text-left" for="department">Departamento</label>
                                    <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" wire:model="department">
                                        <option value="">--escolha o departamento--</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->description }}</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label class="control-label mb-10 text-left" for="subject">Assunto</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject" placeholder="Informe o Assunto" wire:model.lasy="subject" />
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="control-label mb-10 text-left" for="message">Mensagem</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" rows="5" name="message" id="message" placeholder="Informe a mensagem a ser enviada"  wire:model.lasy="message"></textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            <br />
                            
                            <hr />
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-success">
                                    <span class="btn-text">Enviar</span>
                                </button>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
