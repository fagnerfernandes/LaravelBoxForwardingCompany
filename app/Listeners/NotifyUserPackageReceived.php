<?php

namespace App\Listeners;

use App\Enums\MailTemplateTypesEnum;
use App\Events\PackageReceivedEvent;
use App\Mail\TriggeredEmail;
use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserPackageReceived
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
     * @param  \App\Events\PackageReceivedEvent  $event
     * @return void
     */
    public function handle(PackageReceivedEvent $event)
    {
        try {
            $template = MailTemplate::where('type', MailTemplateTypesEnum::PACKAGE_RECEIVED)->first();

            if ($template) {
                $customer = $this->getCustomerData($event->user);
                $package = $this->getPackageData($event->package);
                $variables = array_merge($customer, $package);
    
                Mail::to($event->user)->send(new TriggeredEmail($variables, $template));
            }
        } catch (\Exception $exception) {
            Log::emergency('Falha ao executar evento: Pacote Recebido '. $exception->getMessage());
        }
    }
}
