<?php

namespace App\Listeners;

use App\Enums\MailTemplateTypesEnum;
use App\Events\PurchaseWaitingPaymentEvent;
use App\Mail\TriggeredEmail;
use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserPurchaseWaitingPayment
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
     * @param  \App\Events\PurchaseWaitingPaymentEvent  $event
     * @return void
     */
    public function handle(PurchaseWaitingPaymentEvent $event)
    {
        try {
            $template = MailTemplate::where('type', MailTemplateTypesEnum::PURCHASE_AWAITING_PAYMENT)->first();

            if ($template) {
                $data = $event->data;
                $customer = $this->getCustomerData($data->user);
                $purchase = $this->getPurchaseData($data->purchase);
                $variables = array_merge($customer, $purchase);

                Mail::to($data->user->email)->send(new TriggeredEmail($variables, $template));
            }
        } catch (\Exception $exception) {
            Log::emergency('Falha ao executar evento: Compra Aguardando Pagamento '. $exception->getMessage());
        }
    }
}
