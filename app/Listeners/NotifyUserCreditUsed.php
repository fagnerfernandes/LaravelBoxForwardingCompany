<?php

namespace App\Listeners;

use App\Enums\MailTemplateTypesEnum;
use App\Enums\PaymentMethodsEnum;
use App\Events\CreditUsedEvent;
use App\Mail\TriggeredEmail;
use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserCreditUsed implements ShouldQueue
{
    use EmailVariablesTrait;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CreditUsedEvent  $event
     * @return void
     */
    public function handle(CreditUsedEvent $event)
    {
        try {
            $template = MailTemplate::where('type', MailTemplateTypesEnum::CREDIT_USED)->first();

            if ($template) {
                $data = $event->data->load('payments', 'purchasable.user');
                $customer = $this->getCustomerData($data->purchasable->user);
                $purchase = $this->getPurchaseData($data);
                $credit = $this->getCreditData($event->credit);
                $variables = array_merge($customer, $purchase, $credit);
    
                Mail::to($data->purchasable->user)->send(new TriggeredEmail($variables, $template));
            }
        } catch (\Exception $exception) {
            Log::emergency('Falha ao executar evento: Utilização de Créditos '. $exception->getMessage());
        }
    }
}
