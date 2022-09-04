<?php

namespace App\Listeners;

use App\Enums\MailTemplateTypesEnum;
use App\Events\PackageDeliveredEvent;
use App\Mail\TriggeredEmail;
use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserPackageDelivered
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
     * @param  \App\Events\PackageDeliveredEvent  $event
     * @return void
     */
    public function handle(PackageDeliveredEvent $event)
    {
        try {
            $template = MailTemplate::where('type', MailTemplateTypesEnum::PACKAGE_DELIVERED)->first();

            if ($template) {
                $customer = $this->getCustomerData($event->user);
                $address = $this->getAddressData($event->address);
                $shipping = $this->getShippingData($event->shipping);
                $variables = array_merge($customer, $address, $shipping);
    
                Mail::to($event->user->email)->send(new TriggeredEmail($variables, $template));
            }
        } catch (\Exception $exception) {
            Log::emergency('Falha ao executar evento: Envio de Pacote '. $exception->getMessage());
        }
    }
}
