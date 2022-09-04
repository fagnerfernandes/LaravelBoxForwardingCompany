<?php

namespace App\Http\Livewire;

use App\Models\AffiliateGroup;
use App\Models\CourtesyService;
use App\Models\ExtraService;
use App\Models\PremiumService;
use App\Rules\DuplicatedCourtesyService;
use App\Rules\ExistsOnArray;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AffiliateGroupComponent extends Component
{
    public $affiliateGroup;
    public $affiliateGroupId;
    public $name;
    public $isDefault = false;
    public $companyFeePercent = 0;
    public $premiumServicesPercent = 0;
    public $extraServicesPercent = 0;
    public $freeShippings = [];
    public $courtesyServices = [];
    public $allServices = [];
    public $courtesyService = [];
    public $isEditingService = false;
    public $editingId = 0;
    public $selectedCourtesyServiceIndex = null;

    const EMPTY_COURTESY_SERVICE = [
            'courtesable_id' => '',
            'courtesable_type' => '',
            'name' => '',
            'max_value' => '',
            'valid_days' => ''
    ];

    const EMPTY_FREE_SHIPPINGS = [
        'number_free_shippings' => 0,
        'free_shipping_max_value' => 0,
        'free_shipping_valid_days' => 0
    ];

    public function render()
    {
        return view('livewire.affiliate-group-component');
    }

    public function mount(null|AffiliateGroup $affiliateGroup = null) {
        if ($affiliateGroup) {
            $this->affiliateGroup = $affiliateGroup;
            $this->affiliateGroupId = $affiliateGroup->id;
            $this->name = $affiliateGroup->name;
            $this->isDefault = $affiliateGroup->is_default;
            $this->companyFeePercent = $affiliateGroup->company_fee_percent;
            $this->premiumServicesPercent = $affiliateGroup->premium_services_percent;
            $this->extraServicesPercent = $affiliateGroup->extra_services_percent;

            //courtesy Services
            foreach ($this->affiliateGroup->courtesyServices as $service) {
                $this->courtesyServices[] = [
                    'courtesable_id' => $service->courtesable_id,
                    'courtesable_type' => $service->courtesable_type,
                    'name' => $service->courtesable->name,
                    'max_value' => $service->max_value,
                    'valid_days' => $service->valid_days
                ];
            }

            //free shippings
            $this->freeShippings = [
                'number_free_shippings' => $this->affiliateGroup->number_free_shippings,
                'free_shipping_max_value' => $this->affiliateGroup->free_shipping_max_value,
                'free_shipping_valid_days' => $this->affiliateGroup->free_shipping_valid_days
            ];
        } else {
            $this->freeShippings = self::EMPTY_FREE_SHIPPINGS;
        }

        $this->allServices = $this->getAllServices();

        $this->courtesyService = self::EMPTY_COURTESY_SERVICE;
    }

    public function rules() {
        return [
            'name' => 'required|string|min:3|max:250',
            'courtesyService.courtesable_id' => ['required', new DuplicatedCourtesyService($this->courtesyServices, $this->courtesyService)],
            'courtesyService.max_value' => 'required|gte:0',
            'courtesyService.valid_days' => 'required|gte:0',
            'freeShippings.number_free_shippings' => 'nullable',
            'freeShippings.free_shipping_max_value' => 'nullable',
            'freeShippings.free_shipping_valid_days' => 'nullable'
        ];
    } 

    protected $messages = [
        'courtesyService.courtesable_id' => 'Serviço já incluído.'
    ];

    public function validationAttributes() {
        return [
            'name' => 'Nome',
            'courtesyService.courtesable_id' => 'Serviço',
            'courtesyService.max_value' => 'Valor Máximo',
            'courtesyService.valid_days' => 'Limite de Dias'
        ];
    } 

    public function onSelectedService() {
        if ($this->selectedCourtesyServiceIndex) {
            $this->courtesyService = array_replace($this->courtesyService, $this->allServices[$this->selectedCourtesyServiceIndex]);
        }
    }

    public function storeAffiliateGroup() {
        $this->validateOnly('name');

        try {
            DB::beginTransaction();

            if ($this->affiliateGroupId) {
                //updating
                $this->updateDefaultGroup();
                
                $this->affiliateGroup->update([
                    'name' => $this->name,
                    'is_default' => $this->isDefault ?? false,
                    'company_fee_percent' => $this->companyFeePercent,
                    'premium_services_percent' => $this->premiumServicesPercent,
                    'extra_services_percent' => $this->extraServicesPercent,
                    'number_free_shippings' => $this->freeShippings['number_free_shippings'],
                    'free_shipping_max_value' => $this->freeShippings['free_shipping_max_value'],
                    'free_shipping_valid_days' => $this->freeShippings['free_shipping_valid_days']
                ]);

                $this->createCourtesyServices();

                DB::commit();
    
                flash()->success('Grupo de Affiliados atualizado com sucesso!');
                return redirect()->route('affiliate_groups.index');
            } else {
                //creating
                $this->affiliateGroup = AffiliateGroup::create([
                    'name' => $this->name,
                    'is_default' => $this->isDefault ?? false,
                    'company_fee_percent' => $this->companyFeePercent,
                    'premium_services_percent' => $this->premiumServicesPercent,
                    'extra_services_percent' => $this->extraServicesPercent,
                    'number_free_shippings' => $this->freeShippings['number_free_shippings'],
                    'free_shipping_max_value' => $this->freeShippings['free_shipping_max_value'],
                    'free_shipping_valid_days' => $this->freeShippings['free_shipping_valid_days']
                ]);

                $this->updateDefaultGroup();

                $this->createCourtesyServices();

                DB::commit();
                
                flash()->success('Grupo de Affiliados cadastrado com sucesso!');
                return redirect()->route('affiliate_groups.index');
            }
        } catch (\Exception $exception) {
            DB::rollback();
            dd($exception);
        }
    }

    public function updated($field) {
        $this->validateOnly($field);
    }

    public function updateDefaultGroup() {
        if ($this->isDefault) {
            $defaultGroup = AffiliateGroup::default()->first();
            if ($defaultGroup && $defaultGroup->id != $this->affiliateGroup->id) {
                $defaultGroup->update(['is_default' => false]);
            }
        }       
    }

    public function storeCourtesyService() {
        if ($this->isEditingService) {
            $this->isEditingService = false;
            $this->courtesyServices[$this->editingId] = $this->courtesyService;
            $this->courtesyService = self::EMPTY_COURTESY_SERVICE;
            $this->editingId = 0;

            $this->selectedCourtesyServiceIndex = null;
            $this->dispatchBrowserEvent('closeAddEditServiceModalEvent');
        } else {
            $this->validate();

            $this->courtesyServices[] = $this->courtesyService;
            $this->courtesyService = self::EMPTY_COURTESY_SERVICE;

            $this->selectedCourtesyServiceIndex = null;
            $this->dispatchBrowserEvent('closeAddEditServiceModalEvent');
        }
    }

    public function cancelCourtesyService() {
        $this->dispatchBrowserEvent('closeAddEditServiceModalEvent');

        $this->courtesyService = self::EMPTY_COURTESY_SERVICE;
    }

    public function editCourtesyService($index) {
        $this->courtesyService = $this->courtesyServices[$index];
        $this->selectedCourtesyServiceIndex = $this->searchAllServices($this->courtesyService['courtesable_id'], $this->courtesyService['courtesable_type']);
        $this->isEditingService = true;
        $this->editingId = $index;
    }

    public function deleteCourtesyService($index) {
        $this->selectedCourtesyServiceIndex = $index;
        $this->emit('deleteCourtesyServiceEvent');
    }

    public function deleteCourtesyServiceCofirmed() {
        $this->courtesyServices = array_splice($this->courtesyServices, $this->selectedCourtesyServiceIndex-1, 1);
        $this->emit('closeDeleteConfirmationEvent');
    }

    public function deleteCourtesyServiceCanceled() {
        $this->emit('closeDeleteConfirmationEvent');
    }

    public function getServiceTypeDescription(string $serviceType): string {
        switch ($serviceType) {
            case PremiumService::class:
                return 'Serviço Premium';
                break;

            case ExtraService::class:
                return 'Serviço Extra';
                break;
        }
    }

    protected function getAllServices() {
        $premiumServices = PremiumService::select('id as courtesable_id', 'name')->get()->toArray();
        foreach ($premiumServices as &$premiumService) {
            $premiumService['courtesable_type'] = PremiumService::class;
        }

        $extraServices = ExtraService::select('id as courtesable_id', 'name')->get()->toArray();
        foreach ($extraServices as &$extraService) {
            $extraService['courtesable_type'] = ExtraService::class;
        }

        $services = array_merge($premiumServices, $extraServices);

        return array_combine(range(1, count($services)), $services);
    }

    protected function createCourtesyServices() {
        $this->affiliateGroup->courtesyServices()->delete();

        foreach ($this->courtesyServices as $courtesy) {
            $this->affiliateGroup->courtesyServices()->create([
                'courtesable_id' => $courtesy['courtesable_id'],
                'courtesable_type' => $courtesy['courtesable_type'],
                'max_value' => $courtesy['max_value'],
                'valid_days' => $courtesy['valid_days']
            ]);
        }
    }

    protected function searchAllServices(int $id, string $type): int {
        foreach ($this->allServices as $key => $service) {
            if ($service['courtesable_id'] == $id && $service['courtesable_type'] == $type) {
                return $key;
            }
        }

        return null;
    }
}
