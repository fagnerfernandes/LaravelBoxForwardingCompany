<div class="row">
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="question">Pergunta</label>
        <input type="text" class="form-control" name="question" id="question" placeholder="Informe a questão" value="{{ !empty($faq->question) ? $faq->question : old('question') }}" />
    </div>
    <div class="form-group mb-3 col-md-12">
        <label class="control-label mb-10 text-left" for="answer">Resposta</label>
        <textarea rows="5" class="form-control" name="answer" id="answer" placeholder="Informe a resposta">{{ !empty($faq->answer) ? $faq->answer : old('answer') }}</textarea>
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
    <style>
        .ck-rounded-corners .ck.ck-editor__main>.ck-editor__editable, .ck.ck-editor__main>.ck-editor__editable.ck-rounded-corners {
            height: 250px;
        }
    </style>
    <script src="{{ url('js/ckeditor.js') }}"></script>
    <script>
        const ckeditor = (el) => {
            ClassicEditor
            .create( document.querySelector( el ), {
                licenseKey: '',
            } )
            .then( editor => {
                window.editor = editor;
            } )
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: t0di41dtnzvb-jfha1cexgplv' );
                console.error( error );
            } )
        }
        document.addEventListener('DOMContentLoaded', () => {
            ckeditor('#answer')
        })

    </script>
@endsection

