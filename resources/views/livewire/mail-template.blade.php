<div>
    <div class="row">
        <div class="form-group col-md-8 mb-3">
            <label for="name" class="control-label">Nome</label>
            <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" id="name" wire:model.lazy="name" >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group col-md-4 mb-3">
            <label for="type" class="control-label">Tipo</label>
            <select name="template_type" id="template_type" class="form-control @error('template_type') is-invalid @enderror" wire:model.lazy="template_type">
                <option><-- Selecione um tipo --></option>
                @foreach ($this->types as $type)
                    <option value="{{ $type['value'] }}" >{{ $type['name'] }}</option>
                @endforeach
            </select>
            @error('template_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label for="subject" class="control-label">Assunto</label>
            <div class="input-group has-validation mb-3">
                <input name="subject" id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" wire:model.lazy="subject">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Variáveis do Assunto</button>
                <ul class="dropdown-menu dropdown-menu-end" style="height: auto; max-height: 250px; overflow-x: hidden;">
                    @foreach ($this->variables as $variable)
                        @if (!isset($variable['type']) || $variable['type'] == 'subject')
                        <li><a class="dropdown-item addVarSubject" data-variable="{{ $variable['name'] }}">{{ $variable['label'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-md-12 mb-3">
            <div class="card @error('content') is-invalid border-danger @enderror" @error('content') style="border: 1px solid;"@enderror>
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label>Template</label>
                        
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <label for="templateVariables">Variáveis do Template</label>
                            </div>
                            <div class="col-auto">
                                <select name="templateVariables" id="templateVariables" class="form-control">
                                    <option value="" selected>Selecione</option>
                                    @foreach ($this->variables as $variable)
                                        @if (!isset($variable['type']) || $variable['type'] == 'content')
                                            <option value="{{ $variable['name'] }}">{{ $variable['label'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="mailTemplateEditor" class="mb-2" wire:ignore></div>                   
                </div>
            </div>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <hr />
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('mail_templates.index') }}" class="btn btn-light">
            voltar
        </a>

        <button type="button" class="btn btn-success">
            <span class="btn-text" wire:click.prevent="storeTemplate">Gravar</span>
        </button>
    </div>
</div>
@push('top-css')
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
@endpush

@push('bottom-scripts')
<script src="/js/jquery-insert-text.js"></script>
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
<script>
    $(() => {
        var fireTemplateUpdate = true;
        if (@this.get('content')) {
            editor.setMarkdown(@this.get('content'))
        }

        $('#templateVariables').on('change', (e) => {
            let valor = '\{' + $(e.target).val() + '\}'
            editor.insertText(valor)
            $(`#templateVariables option[value='']`).prop('selected', true);
        })   

        $(document).on('click', '.addVarSubject', (e) => {
            let valor = '\{' + $(e.target)[0].dataset['variable'] + '\}'
            $('#subject').addText(valor)
            @this.set('subject', $('#subject').val())
        })
        
        editor.on('blur', (e) => {
            @this.set('content', editor.getMarkdown());
        })
    })
    const editor = new toastui.Editor({
        el: document.querySelector('#mailTemplateEditor'),
        height: '500px',
        initialEditType: 'wysiwyg'
    });    
</script>
@endpush