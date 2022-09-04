<?php

namespace App\Http\Livewire;

use App\Enums\CreditTransactionTypesEnum;
use App\Enums\PaymentGatewaysEnum;
use App\Enums\PaymentMethodsEnum;
use App\Enums\PurchaseStatusEnum;
use App\Events\CreditUsedEvent;
use App\Models\AssistedPurchase;
use App\Models\Credit;
use App\Models\PremiumShopping;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Payment extends Component
{
    public $withCredits = false;
    public $useCredits = false;
    public $appliedCredits = false;
    public $showPaymentGateways = true;
    public $creditUsed = 0;
    public $creditAvailable = 0;
    public $amount = 0;
    public $modelClass = null;
    public $modelObject = null;
    public $transaction = null;
    public $gateway = null;
    public $purchase = null;
    public $creditPaymentId = null;

    public function render()
    {
        return view('livewire.payment');
    }

    public function mount() {
        if ($this->withCredits) {
            $this->creditAvailable = Auth::user()->creditBalance();
        }

        if (!$this->modelObject->purchase) {
            Log::debug($this->modelClass);
            switch ($this->modelClass) {
                case Credit::class:
                    $value = $this->modelObject->amount;
                    break;
                
                case Shipping::class: 
                    $value = $this->modelObject->value;
                    break;

                case PremiumShopping::class:
                    $value = $this->modelObject->price;
                    break;

                case AssistedPurchase::class:
                    $value = $this->modelObject->price;
                    break;

                default:
                    $value = $this->modelObject->value;
            }

            $this->purchase = $this->modelObject->purchase()->create(['value' => $value]);
        } else {
            $this->purchase = $this->modelObject->purchase;
            foreach ($this->purchase->payments as $payment) {
                if ($payment->payment_method == PaymentMethodsEnum::CREDIT) {
                    $this->creditUsed = $payment->value;
                    $this->appliedCredits = true;
                    $this->useCredits = true;
                    $this->creditPaymentId = $payment->id;

                    $this->showPaymentGateways = ((float)$this->creditUsed < (float)$this->amount);
                }
            }
        }
    }

    public function getUrlPaypalProperty() {
        return $this->getRoute(PaymentGatewaysEnum::PAYPAL);
    }

    public function getUrlCambioRealProperty() {
        return $this->getRoute(PaymentGatewaysEnum::CAMBIOREAL);
    }

    public function getRoute(string $gateway) {
        switch ($this->modelClass) {
            case Credit::class:
                return route('customer.credits.pay', ['id' => $this->modelObject->id, 'gateway' => $gateway]);
                break;
            
            case AssistedPurchase::class:
                return route('customer.assisted_purchases.pay', ['id' => $this->modelObject->id, 'gateway' => $gateway]);
                break;

            case PremiumShopping::class:
                return route('customer.premium_shoppings.pay', ['id' => $this->modelObject->id, 'gateway' => $gateway]);
                break;
            
            case Shipping::class: 
                return route('customer.shippings.pay', ['id' => $this->modelObject->id, 'gateway' => $gateway]);
                break;
        }
    }

    public function activeCredits($useCredits) {
        $this->useCredits = $useCredits;
        $this->showPaymentGateways = !$useCredits;
    }

    public function applyCredits() {
        try {
            DB::beginTransaction();

            $this->creditPaymentId = $this->purchase->payments()->create([
                'payment_method' => PaymentMethodsEnum::CREDIT,
                'value' => $this->creditUsed
            ]);
    
            $credit = Auth::user()->credits()->create([
                'amount' => $this->creditUsed,
                'status' => 1,
                'description' => $this->getCreditTransactionMessage(),
                'type' => CreditTransactionTypesEnum::OUT
            ]);

            event(new CreditUsedEvent($this->purchase, $credit));

            DB::commit();

            $this->appliedCredits = true;
            if ((float)$this->creditUsed < (float)$this->amount) {
                $this->showPaymentGateways = true;
            }
        } catch (\Exception $exception) {
            Log::emergency($exception);
            DB::rollBack();
        }
    }

    public function cancelCredits() {
        try {
            DB::beginTransaction();

            $this->purchase->payments->find($this->creditPaymentId)->delete();

            Auth::user()->credits()->create([
                'amount' => $this->creditUsed,
                'status' => 1,
                'description' => $this->getCreditTransactionMessage(true),
                'type' => CreditTransactionTypesEnum::IN
            ]);

            DB::commit();

            $this->appliedCredits = false;
            $this->useCredits = false;
            $this->creditUsed = 0;
            $this->showPaymentGateways = true;    
            $this->creditPaymentId = null;

        } catch (\Exception $exception) {
            Log::emergency($exception);
            DB::rollBack();
        }
    }

    public function getCreditTransactionMessage(bool $canceled = false) {
        switch ($this->modelClass) {
            case Shipping::class:
                $message = 'Solicitação de Envio';
                break;
            
            case PremiumShopping::class: 
                $message = 'Compra de Serviço Premium';
                break;

            case AssistedPurchase::class: 
                $message = 'Compra Assistida';
                break;
        }

        return $canceled ? $message.' (Cancelado)' : $message;
    }

    public function finishWithCredits() {
        $this->modelObject->purchase()->update(['purchase_status_id' => PurchaseStatusEnum::PAYED]);

        switch ($this->modelClass) {
            case Shipping::class:
                $this->modelObject->update(['status' => Shipping::INPROGRESS]);
                $route = route('customer.shippings.index');
                break;
            
            case PremiumShopping::class: 
                $this->modelObject->update(['status' => 2]);
                $route = route('customer.premium_shoppings.index');
                break;

            case AssistedPurchase::class: 
                $this->modelObject->update(['status' => 2]);
                $route = route('customer.assisted-purchases.index');
                break;
        }

        return $this->redirect($route);
    }

   /*  public function finishPayment($payWith) {
            $transaction = (new PaymentsPayment())->register($this->modelObject, $payWith, $request->all());
            return redirect($transaction->bill_url);

    } */
}
