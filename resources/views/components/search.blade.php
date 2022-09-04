<div class="bg-light pt-4 px-4 pb-2">
    <form action=""{{ $attributes->get('action') ?? '' }}>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar por..." aria-label="Busca de endereços" aria-describedby="btn-search" name="keyword" id="keyword" value="{{ request()->has('keyword') ? request()->get('keyword') : '' }}" />
            <button class="btn btn-outline-secondary" type="button" id="btn-search">
                <i class="bx bx-search"></i>
            </button>
        </div>

        @if (request()->has('keyword') && !empty(request()->get('keyword')))
            <a href="{{ $attributes->get('action') ?? '' }}" class="btn btn-sm btn-outline-secondary">
                limpar filtros <i class="bx bx-x"></i>
            </a>
        @endif
    </form>
</div>
