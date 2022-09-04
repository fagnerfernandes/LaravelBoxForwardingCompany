<div class="row">
    <div class="col-sm-12">
        <div class="card round-10 w-100">
            <div class="card-header">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark"><i class="zmdi zmdi-account"></i>Calcule o seu frete aqui!</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <div class="panel-body">
                    <div class="form-wrap">
                        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-3 form-group mb-3 {{ $errors->has('user.name') ? 'has-error' : ''}}">
                                    <label for="user.name" class="control-label">{{ 'Unidade' }}</label>
                                    <select class="form-control" name="category_id" id="category_id" wire:model="unit">
                                        <option value="LB">Lbs</option>
                                        <option value="KG">Quilos</option>
                                    </select>
                                </div><div class="col-md-2 form-group mb-3 {{ $errors->has('user.name') ? 'has-error' : ''}}">
                                    <label for="user.name" class="control-label">{{ 'Peso' }}</label>
                                    <input type="number" name="peso" id="peso" placeholder="peso" class="form-control" wire:model="weight">
                                </div>
                                <div class="col-md-7 form-group mb-3">
                                    {{-- <label for="customRange3" class="form-label"></label> --}}
                                    <div class="d-flex justify-content-between">
                                        <span class="bedge p-2 mt-4 ml-2">0</span>
                                        <input type="range" value="0" class="form-range mt-4 pt-3" min="0" max="66" step="1" id="customRange3" wire:model.lazy="weight"> 
                                        <span class="bedge p-2 mt-4 mr-1">{{ $weight }}/66</span>     
                                    </div>
                                                                  
                                </div>
                            </div>
                            <livewire:shipping-quote />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
