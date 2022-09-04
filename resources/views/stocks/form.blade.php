<div class="row">
    <div class="form-group col-md-12">
        <label class="control-label mb-10 text-left" for="product_id">Tipo de movimentação</label>
        <select class="form-control" name="product_id" id="product_id">
            <option value=""></option>
            @foreach ($products as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label class="control-label mb-10 text-left" for="type">Tipo de movimentação</label>
        <select class="form-control" name="type" id="type">
            <option value=""></option>
            @foreach ($types as $type => $description)
                <option value="{{ $type }}">{{ $description }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group col-md-6">
        <label class="control-label mb-10 text-left" for="amount">Quantidade</label>
        <input type="number" min="0" step="1" class="form-control" name="amount" id="amount" />
    </div>

    <div class="form-group col-md-12">
        <label class="control-label mb-10 text-left" for="description">Descrição (opcional)</label>
        <textarea class="form-control" name="description" id="description" rows="5"></textarea>
    </div>
</div>

{{-- <hr /> --}}
<button type="submit" class="btn btn-success">
    <span class="btn-text">Gravar</span>
</button>

