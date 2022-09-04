<div class="col-md-12">
    <div class="position-relative d-flex justify-content-center align-items-center">
        {{-- <div class="progress" style="height: 1px;">
            <div class="progress-bar" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div> --}}
        <button type="button" class="translate-middle btn btn-sm {{ (int)$step >= 1 ? 'btn-primary' : 'btn-secondary' }} rounded-pill mx-4" style="width: 2rem; height:2rem;">1</button>
        <button type="button" class="translate-middle btn btn-sm {{ (int)$step >= 2 ? 'btn-primary' : 'btn-secondary' }} rounded-pill mx-4" style="width: 2rem; height:2rem;">2</button>
        <button type="button" class="translate-middle btn btn-sm {{ (int)$step >= 3 ? 'btn-primary' : 'btn-secondary' }} rounded-pill mx-4" style="width: 2rem; height:2rem;">3</button>
        <button type="button" class="translate-middle btn btn-sm {{ (int)$step >= 4 ? 'btn-primary' : 'btn-secondary' }} rounded-pill mx-4" style="width: 2rem; height:2rem;">4</button>
        <button type="button" class="translate-middle btn btn-sm {{ (int)$step >= 5 ? 'btn-primary' : 'btn-secondary' }} rounded-pill mx-4" style="width: 2rem; height:2rem;">5</button>
        <button type="button" class="translate-middle btn btn-sm {{ (int)$step >= 6 ? 'btn-primary' : 'btn-secondary' }} rounded-pill mx-4" style="width: 2rem; height:2rem;">6</button>
    </div>
</div>