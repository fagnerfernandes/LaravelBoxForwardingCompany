<div>
    <div class="row">
        <div class="form-group mb-3 col-md-8">
            <label class="control-label mb-10 text-left" for="name">Nome</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nome" wire:model.lasy="name" />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-4 d-flex align-items-end">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isDefault" wire:model.lazy="isDefault">
                <label class="form-check-label" for="isDefault">Grupo de Afiliados Padrão</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Participação de Afiliados
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="control-label mb-10 text-left" for="companyFeePercent">Taxa Company</label>
                            <input type="number" min="0.00" max="100.00" step="0.01" class="form-control @error('companyFeePercent') is-invalid @enderror" name="companyFeePercent" id="companyFeePercent" placeholder="Taxa Company" wire:model.lasy="companyFeePercent" />
                            @error('companyFeePercent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label mb-10 text-left" for="premiumServicesPercent">Serviços Premium</label>
                            <input type="number" min="0.00" max="100.00" step="0.01" class="form-control @error('premiumServicesPercent') is-invalid @enderror" name="premiumServicesPercent" id="premiumServicesPercent" placeholder="Serviços Premium" wire:model.lasy="premiumServicesPercent" />
                            @error('premiumServicesPercent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="control-label mb-10 text-left" for="extraServicesPercent">Serviços Extras</label>
                            <input type="number" min="0.00" max="100.00" step="0.01" class="form-control @error('extraServicesPercent') is-invalid @enderror" name="extraServicesPercent" id="extraServicesPercent" placeholder="Serviços Extras" wire:model.lasy="extraServicesPercent" />
                            @error('extraServicesPercent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Envios Gratuitos
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="control-label mb-10 text-left" for="freeShippings.number_free_shippings">Quantidade</label>
                            <input type="number" min="0" max="9999" step="1" class="form-control @error('freeShippings.number_free_shippings') is-invalid @enderror" name="freeShippings.number_free_shippings" id="freeShippings.number_free_shippings" placeholder="Quantidade" wire:model.lasy="freeShippings.number_free_shippings" />
                            @error('freeShippings.number_free_shippings')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label mb-10 text-left" for="freeShippings.free_shipping_max_value">Valor Máximo por Envio</label>
                            <input type="number" min="0.00" max="100.00" step="0.01" class="form-control @error('freeShippings.free_shipping_max_value') is-invalid @enderror" name="freeShippings.free_shipping_max_value" id="freeShippings.free_shipping_max_value" placeholder="Valor Máximo por Envio" wire:model.lasy="freeShippings.free_shipping_max_value" />
                            @error('freeShippings.free_shipping_max_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="control-label mb-10 text-left" for="freeShippings.free_shipping_valid_days">Validade (dias)</label>
                            <input type="number" min="0" max="9999" step="1" class="form-control @error('freeShippings.free_shipping_valid_days') is-invalid @enderror" name="freeShippings.free_shipping_valid_days" id="freeShippings.free_shipping_valid_days" placeholder="Validade (dias)" wire:model.lasy="freeShippings.free_shipping_valid_days" />
                            @error('freeShippings.free_shipping_valid_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Serviços Cortesia</span>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAddEditServices">Adicionar</button>
                </div>
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Serviço</th>
                            <th scope="col">Tipo de Serviço</th>
                            <th scope="col">Limite Valor</th>
                            <th scope="col">Validade (dias)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!count($courtesyServices))
                            <tr>
                                <td colspan="8" class="text-center"><strong>Não há serviços cadastrados..</strong></td>
                            </tr>
                        @else
                            @foreach ($courtesyServices as $index => $courtesy) 
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $courtesy['name'] ?? '' }}</td>
                                    <td>{{ $this->getServiceTypeDescription($courtesy['courtesable_type']) }}</td>
                                    <td>@currency($courtesy['max_value'])</td>
                                    <td>{{ $courtesy['valid_days'] }}</td>
                                    <td class="text-end py-1">
                                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddEditServices" wire:click.prevent="editCourtesyService({{ $index }})">
                                            <i class="bx bx-edit"  style="margin-right: 0px !important"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm" wire:click.prevent="deleteCourtesyService({{ $index }})">
                                            <i class="bx bx-trash"  style="margin-right: 0px !important"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr />
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('affiliate_groups.index') }}" class="btn btn-light">
            voltar
        </a>

        <button type="button" class="btn btn-success">
            <span class="btn-text" wire:click.prevent="storeAffiliateGroup">Gravar</span>
        </button>
    </div>
    <div class="modal fade show" id="modalAddEditServices" tabindex="-1" aria-modal="true" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEditingService ? 'Alteração' : 'Inclusão' }} de Serviço Cortezia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="serviceSelect">Serviço</label>
                                <select name="serviceSelect" id="serviceSelect" class="form-control @error('courtesyService.courtesable_id') is-invalid @enderror" wire:model="selectedCourtesyServiceIndex" wire:change.lazy="onSelectedService">
                                    <option value="">Selecione um Serviço</option>
                                    @foreach ($allServices as $index => $service)
                                        <option value="{{ $index }}">{{ $service['name'] ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('courtesyService.courtesable_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="maxValue">Valor Máximo</label>
                                <input type="number" min="0.00" max="9999.99" step="0.01" class="form-control @error('courtesyService.max_value') is-invalid @enderror" placeholder="Valor Máximo" wire:model.lazy="courtesyService.max_value">
                                @error('courtesyService.max_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="maxDays">Validade (dias)</label>
                                <input type="number" min="0" max="999" step="1" class="form-control @error('courtesyService.valid_days') is-invalid @enderror" placeholder="Validade (dias)" wire:model.lazy="courtesyService.valid_days">
                                @error('courtesyService.valid_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" wire:click.prevent="cancelCourtesyService">Cancelar</button>
                    <button class="btn btn-success" wire:click.prevent="storeCourtesyService">Gravar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal ade show" id="modalConfirmDelCourtesy" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atenção</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="deleteCourtesyServiceCanceled"></button>
                </div>
                <div class="modal-body">
                    <p>Confirma Exclusão de Serviço?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent="deleteCourtesyServiceCanceled">Cancelar</button>
                    <button class="btn btn-success" data-bs-dismiss="modal" wire:click.prevent="deleteCourtesyServiceCofirmed">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('bottom-scripts')
    <script>
        Livewire.on('deleteCourtesyServiceEvent', (e) => {
            $('#modalConfirmDelCourtesy').show()
        })
        Livewire.on('closeDeleteConfirmationEvent', (e) => {
            $('#modalConfirmDelCourtesy').hide()
        })
        window.addEventListener('closeAddEditServiceModalEvent', (e) => {
            $('#modalAddEditServices').modal('hide')
        })
        window.addEventListener('editCourtesyServiceEvent', (e) => {
            $('#modalAddEditServices').show()
        })
    </script>
@endpush