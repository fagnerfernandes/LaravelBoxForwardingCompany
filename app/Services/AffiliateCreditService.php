<?php

namespace App\Services;

use App\Models\User;
use App\Models\Credit;
use App\Models\AffiliateBenefit;
use Illuminate\Support\Facades\Config;
use App\Enums\AffiliateBenefitTypesEnum;
use App\Enums\CreditTransactionTypesEnum;

class AffiliateCreditService {
    

    public function generateCredit(int $userId, AffiliateBenefitTypesEnum $benefitType, float $value) {
        $affiliado = $this->loadData($userId);

        $benefit = AffiliateBenefit::where('affiliate_id', $affiliado->userable->id)
                            ->benefitType($benefitType)
                            ->first();

    if ($benefit) {
            $this->addCredit(
                $benefit->customer->user,
                $this->getCreditValue($value, $benefit->percent)
            );
        }        
    }

    public function loadData(int $userId) {
        return User::with([
            'userable.affiliatedTo.user',
            'userable.affiliatedTo.affiliateGroup'
        ])->where('id', $userId)->first();
    }

    protected function addCredit(User $usuario, float $value) {
        $data = [
            'user_id' => $usuario->id,
            'amount' => $value,
            'status' => 1,
            'description' => 'Crédito Programa de Afiliados',
            'type' => CreditTransactionTypesEnum::IN
        ];

        try {
            Config::set('customer.disableScope', true);
            $credit = Credit::create($data);
            $credit->transaction()->create([
                'gateway' => 'internal',
                'token' => 'AFFILIATE',
                'status' => 1,
                'amount' => $credit->amount
            ]);
        } finally {
            Config::set('customer.disableScope', false);
        }
    }

    protected function getCreditValue(float $amount, float $percent): float {
        return $amount * ($percent / 100);
    }
}