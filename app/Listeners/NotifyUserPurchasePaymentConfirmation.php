<?php

namespace App\Listeners;

use App\Enums\MailTemplateTypesEnum;
use App\Events\PurchasePaymentConfirmationEvent;
use App\Mail\TriggeredEmail;
use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserPurchasePaymentConfirmation
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
     * @param  \App\Events\PurchasePaymentConfirmationEvent  $event
     * @return void
     */
    public function handle(PurchasePaymentConfirmationEvent $event)
    {
        try {
            $template = MailTemplate::where('type', MailTemplateTypesEnum::PURCHASE_PAYED)->first();

            if ($template) {
                $data = $event->data;
                $customer = $this->getCustomerData($data->user);
                $purchase = $this->getPurchaseData($data->purchase);
                $variables = array_merge($customer, $purchase);

                Mail::to($data->user->email)->send(new TriggeredEmail($variables, $template));
            }
        } catch (\Exception $exception) {
            Log::emergency('Falha ao executar evento: Confirmação de Pagamento '. $exception->getMessage());
        }
    }
}
