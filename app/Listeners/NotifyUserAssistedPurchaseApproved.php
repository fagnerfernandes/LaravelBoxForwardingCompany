<?php

namespace App\Listeners;

use App\Enums\MailTemplateTypesEnum;
use App\Events\AssistedPurchaseApprovedEvent;
use App\Mail\TriggeredEmail;
use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserAssistedPurchaseApproved
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
     * @param  \App\Events\AssistedPurchaseApprovedEvent  $event
     * @return void
     */
    public function handle(AssistedPurchaseApprovedEvent $event)
    {
        try {
            $template = MailTemplate::where('type', MailTemplateTypesEnum::ASSISTED_PURCHASE_APPROVED)->first();

            if ($template) {
                $customer = $this->getCustomerData($event->assistedPurchase->user);
                $assistedPurchase = $this->getAssistedPurchaseData($event->assistedPurchase);
                $variables = array_merge($customer, $assistedPurchase);

                Mail::to($event->assistedPurchase->user->email)->send(new TriggeredEmail($variables, $template));
            }
        } catch (\Exception $exception) {
            Log::emergency('Falha ao executar evento: Aprovação de Compra Assistida '. $exception->getMessage());
        }
    }
}
