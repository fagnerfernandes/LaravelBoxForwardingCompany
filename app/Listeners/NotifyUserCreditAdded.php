<?php

namespace App\Listeners;

use App\Enums\MailTemplateTypesEnum;
use App\Events\CreditAddedEvent;
use App\Mail\TriggeredEmail;
use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserCreditAdded implements ShouldQueue
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
     * @param  \App\Events\CreditAddedEvent  $event
     * @return void
     */
    public function handle(CreditAddedEvent $event)
    {      
        try {
            $template = MailTemplate::where('type', MailTemplateTypesEnum::CREDIT_ADDED)->first();

            if ($template) {
                $data = $event->data;
                $customer = $this->getCustomerData($data->user);
                $purchase = $this->getPurchaseData($data->purchase);
                $credit = $this->getCreditData($data);
                $variables = array_merge($customer, $purchase, $credit);

                Mail::to($event->data->user->email)->send(new TriggeredEmail($variables, $template));
            }
        } catch (\Exception $exception) {
            Log::emergency('Falha ao executar evento: Adição de Créditos '. $exception->getMessage());
        }
    }
}
