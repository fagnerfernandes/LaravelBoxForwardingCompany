<?php

namespace App\ExternalApi\Payments;

use App\Enums\AffiliateBenefitTypesEnum;
use App\Enums\PaymentGatewaysEnum;
use App\Enums\PaymentMethodsEnum;
use App\Enums\PurchaseStatusEnum;
use App\Events\CreditAddedEvent;
use App\Events\PurchasePaymentConfirmationEvent;
use App\Events\PurchaseWaitingPaymentEvent;
use App\Models\AssistedPurchase;
use App\Models\Credit;
use App\Models\PremiumShopping;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Services\AffiliateCreditService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Payment
{
    public function register($model, string $gateway, array $params = []): ?Transaction
    {
        try {
            if ($gateway == PaymentGatewaysEnum::CAMBIOREAL) {
                try {
                    DB::beginTransaction();

                    $amount = $model->purchase->totalOpen();
                    $result = (new CambioReal())->request(
                        $model->id,
                        $this->getDescription($model::class),
                        $amount
                    );

                    
                    $transaction = $model->transaction()->create([
                        'gateway' => $result['gateway'],
                        'token' => $result['token'],
                        'bill_url' => $result['bill_url'],
                        'amount' => $result['amount'],
                    ]);
                    
                    $model->purchase->payments()->create([
                        'payment_method' => PaymentMethodsEnum::CAMBIOREAL,
                        'value' => $result['amount'],
                        'transaction_id' => $transaction->id
                    ]);

                    $model->purchase()->update(['purchase_status_id' => PurchaseStatusEnum::WAITING_APPROVAL]);

                    DB::commit();

                    switch ($model::class) {
                        case PremiumShopping::class:
                        case AssistedPurchase::class:
                        case Shipping::class:
                            event(new PurchaseWaitingPaymentEvent($model));
                            break;
                    }

                    return $transaction;
                } catch (\Exception $exception) {
                    Log::emergency($exception);
                    DB::rollBack();
                }
            } else if ($gateway == PaymentGatewaysEnum::PAYPAL) {
                try {
                    DB::beginTransaction();

                    $result = (new Paypal())->getOrder($params['transaction']);
    
                    $transaction = $model->transaction()->create([
                        'gateway' => $result['gateway'],
                        'token' => $result['orderID'],
                        'bill_url' => $this->getResponseRoute($model::class),
                        'amount' => $result['amount'],
                        'status' => $result['status'],
                    ]);

                    $model->purchase->payments()->create([
                        'payment_method' => PaymentMethodsEnum::PAYPAL,
                        'value' => $result['amount'],
                        'transaction_id' => $transaction->id
                    ]);

                    if ($result['status']) {
                        $model->purchase()->update(['purchase_status_id' => PurchaseStatusEnum::PAYED]);
                        $model->update(['status' => 1]);
                        
                        switch ($model::class) {
                            case Credit::class:
                                Log::info('Compra de credito, não pode aparecer no log');
                                event(new CreditAddedEvent($model));
                                break;
                            
                            case PremiumShopping::class:
                                event(new PurchasePaymentConfirmationEvent($model));
                                (new AffiliateCreditService())->generateCredit(
                                    $model->user_id, 
                                    AffiliateBenefitTypesEnum::PREMIUM_SERVICE_PERCENT, 
                                    $model->purchase->value
                                );
                                break;

                            case AssistedPurchase::class:
                                event(new PurchasePaymentConfirmationEvent($model));
                                (new AffiliateCreditService())->generateCredit(
                                    $model->user_id, 
                                    AffiliateBenefitTypesEnum::COMPANY_FEE_PERCENT, 
                                    $model->purchase->value
                                );
                                break;

                            case Shipping::class:
                                event(new PurchasePaymentConfirmationEvent($model));
                                if (Auth::user()->userable->affiliatedTo) {
                                    //affiliate percent over extra service (if customer has contracted some)
                                    $extraValue = 0;
                                    foreach ($model->extra_services as $extraService) {
                                        $extraValue += $extraService->price;
                                    }
    
                                    //if affiliat has percent on extra-services
                                    $extraServiceBenefit = Auth::user()->userable->affiliatedTo->affiliateBenefits()->benefitType(AffiliateBenefitTypesEnum::EXTRA_SERVICE_PERCENT)->first();
                                    if ($extraServiceBenefit) {
                                        $valueBenefitExtra = $extraValue * ($extraServiceBenefit->percent / 100);
                                    } else {
                                        $valueBenefitExtra = 0;
                                    }
    
                                    //affiliate percent over company fee
                                    $companyValue = ($model->purchase->value + $valueBenefitExtra) * ($model->fee() / 100);
                                    (new AffiliateCreditService())->generateCredit(
                                        Auth::user()->id, 
                                        AffiliateBenefitTypesEnum::PREMIUM_SERVICE_PERCENT, 
                                        $companyValue
                                    );
                                }
                                break;
                        }
                    }

                    DB::commit();

                    return $transaction;
                } catch (\Exception $exception) {
                    Log::emergency($exception);
                    DB::rollBack();
                }
            }
            return null;
        } catch (\Exception $e) {
            logger()->error('Houve um erro ao registrar a transação', [
                $e->getMessage(),
                $e->getLine()
            ]);
            throw new \Exception('Has been an error: '. $e->getMessage() .'('. $e->getFile() .'|'. $e->getLine() .')');
        }
    }

    private function getDescription($modelClass) {
        switch ($modelClass) {
            case Shipping::class:
                $desc = 'Solicitação de envio';
                break;

            case Credit::class:
                $desc = 'Compra de crédito';
                break;

            case PremiumShopping::class:
                $desc = 'Compra de serviço premium';
                break;

            case AssistedPurchase::class:
                $desc = 'Compra assistida';
                break;
        }
        
        return $desc;
    }

    private function getResponseRoute($modelClass) {
        switch ($modelClass) {
            case Shipping::class:
                $route = route('customer.shippings.index');
                break;

            case Credit::class:
                $route = route('customer.credits.index');
                break;

            case PremiumShopping::class:
                $route = route('customer.premium_shoppings.index');
                break;

            case AssistedPurchase::class:
                $route = route('customer.assisted-purchases.index');
                break;
        }

        return $route;
    }
}
