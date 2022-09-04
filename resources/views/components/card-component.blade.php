<div class="card radius-10 overflow-hidden">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
                <p class="mb-0">{{ $attributes->get('title') }}</p>
                <h6 class="mb-0">{!! $attributes->get('value') !!}</h6>
            </div>
            <div class="ms-auto">
                <i class="bx {{ $attributes->get('icon') }} font-30"></i>
            </div>
        </div>
    </div>
</div>
