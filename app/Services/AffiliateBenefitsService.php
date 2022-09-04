<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\CourtesyService;
use App\Enums\AffiliateBenefitTypesEnum;

class AffiliateBenefitsService {
    protected $customer;
    
    const AFFILIATED_TO_BENEFITS_COLUMNS = [
        'company_fee_percent',
        'premium_services_percent',
        'extra_services_percent'
    ];

    public function __construct(Customer $customer) {
        $this->customer = $customer;
        $this->loadAffiliateRelationships();
    }

    public function createBenefits() {
        $this->createAffiliatedToPercentBenefits();
        $this->createCourtesyServiceBenefits();
    }

    protected function loadAffiliateRelationships() {
        $this->customer->load([
            'affiliatedTo.affiliateGroup.courtesyServices', 
            'affiliatedTo.user'
        ]);
    }

    protected function createAffiliatedToPercentBenefits() {
        $benefits = $this->customer->affiliatedTo->affiliateGroup->only(self::AFFILIATED_TO_BENEFITS_COLUMNS);
        foreach ($benefits as $key => $value) {
            switch ($key) {
                case 'company_fee_percent':
                    $this->persistePercentBenefit(
                        $this->customer->affiliatedTo,
                        AffiliateBenefitTypesEnum::COMPANY_FEE_PERCENT,
                        floatval($value));
                    break;
                case 'premium_services_percent':
                    $this->persistePercentBenefit(
                        $this->customer->affiliatedTo,
                        AffiliateBenefitTypesEnum::PREMIUM_SERVICE_PERCENT,
                        floatval($value));
                    break;
                case 'extra_services_percent':
                    $this->persistePercentBenefit(
                        $this->customer->affiliatedTo,
                        AffiliateBenefitTypesEnum::EXTRA_SERVICE_PERCENT,
                        floatval($value));
                    break;
            }
        }
    }

    protected function createCourtesyServiceBenefits() {
        foreach ($this->customer->affiliatedTo->affiliateGroup->courtesyServices as $courtesyService) {
            $this->createAffiliatedCourtesyServices($courtesyService);
        }

        for ($i = 1; $i <= $this->customer->affiliatedTo->affiliateGroup->number_free_shippings; $i++) {
            $this->customer->affiliateCourtesyServices()->create([
                'service_type' => AffiliateBenefitTypesEnum::FREE_SHIPPING,
                'max_value' => $courtesyService->max_value,
                'valid_until' => Carbon::now()->addDays($courtesyService->valid_days)
            ]);
        }
    }

    protected function createAffiliatedCourtesyServices(CourtesyService $courtesyService) {
        $this->customer->affiliateCourtesyServices()->create([
            'service_type' => AffiliateBenefitTypesEnum::COURTESY_SERVICE,
            'courtesable_type' => $courtesyService->courtesable_type,
            'courtesable_id' => $courtesyService->courtesable_id,
            'max_value' => $courtesyService->max_value,
            'valid_until' => Carbon::now()->addDays($courtesyService->valid_days)
        ]);
    }

    protected function persistePercentBenefit(Customer $customer, AffiliateBenefitTypesEnum $benefitType, float $percent) {
        if ($percent > 0) {
            $customer->affiliateBenefits()->create([
                'affiliate_id' => $this->customer->id,
                'benefit_type' => $benefitType,
                'percent' => $percent
            ]);
        }
    }
}