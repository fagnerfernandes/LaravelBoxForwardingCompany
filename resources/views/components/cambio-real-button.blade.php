<button id="btnCambioReal" class="d-block btn btn-success btn-lg w-100" data-parent="{{ $attributes->get('parent') }}" data-url="{{ $attributes->get('url') }}" data-price="{{ $attributes->get('price') }}" {{-- style="height: 55px" --}}>
    <i class="lni lni-empty-file"></i>
    Pagar com Câmbio Real
</button>

@push('bottom-scripts')
<script>
    $(() => {
        $('#btnCambioReal').on('click', (e) => {
            window.open($('#btnCambioReal')[0].dataset['url']);
            $(`#${$('#btnCambioReal')[0].dataset['parent']}`).html('Redirecionando para a Cambio Real.');
        })
    })
</script>
@endpush