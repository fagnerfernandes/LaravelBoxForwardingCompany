<?php

namespace App\Listeners;

use App\Enums\MailTemplateTypesEnum;
use App\Events\AssistedPurchaseFinishedEvent;
use App\Mail\TriggeredEmail;
use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserAssistedPurchaseFinished
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
     * @param  \App\Events\AssistedPurchaseFinishedEvent  $event
     * @return void
     */
    public function handle(AssistedPurchaseFinishedEvent $event)
    {
        try {
            $template = MailTemplate::where('type', MailTemplateTypesEnum::ASSISTED_PURCHASE_FINISHED)->first();

            if ($template) {
                $customer = $this->getCustomerData($event->assistedPurchase->user);
                $assistedPurchase = $this->getAssistedPurchaseData($event->assistedPurchase);
                $variables = array_merge($customer, $assistedPurchase);

                Mail::to($event->assistedPurchase->user->email)->send(new TriggeredEmail($variables, $template));
            }
        } catch (\Exception $exception) {
            Log::emergency('Falha ao executar evento: Finalização de Compra Assistida '. $exception->getMessage());
        }
    }
}
