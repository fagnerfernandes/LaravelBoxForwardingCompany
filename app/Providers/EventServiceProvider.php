<?php

namespace App\Providers;

use App\Events\AssistedPurchaseApprovedEvent;
use App\Events\AssistedPurchaseCanceledEvent;
use App\Events\AssistedPurchaseFinishedEvent;
use App\Events\CreditAddedEvent;
use App\Events\CreditUsedEvent;
use App\Events\PackageDeliveredEvent;
use App\Events\PackageReceivedEvent;
use App\Events\PurchasePaymentConfirmationEvent;
use App\Events\PurchaseWaitingPaymentEvent;
use App\Events\TesteCreditoEvent;
use App\Listeners\NotifyUserAssistedPurchaseApproved;
use App\Listeners\NotifyUserAssistedPurchaseCanceled;
use App\Listeners\NotifyUserAssistedPurchaseFinished;
use App\Listeners\NotifyUserCreditAdded;
use App\Listeners\NotifyUserCreditUsed;
use App\Listeners\NotifyUserPackageDelivered;
use App\Listeners\NotifyUserPackageReceived;
use App\Listeners\NotifyUserPurchasePaymentConfirmation;
use App\Listeners\NotifyUserPurchaseWaitingPayment;
use App\Listeners\OnTesteCredito;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreditAddedEvent::class => [
            NotifyUserCreditAdded::class
        ],
        CreditUsedEvent::class => [
            NotifyUserCreditUsed::class
        ],
        PackageReceivedEvent::class => [
            NotifyUserPackageReceived::class
        ],
        PackageDeliveredEvent::class => [
            NotifyUserPackageDelivered::class
        ],
        PurchaseWaitingPaymentEvent::class => [
            NotifyUserPurchaseWaitingPayment::class
        ],
        PurchasePaymentConfirmationEvent::class => [
            NotifyUserPurchasePaymentConfirmation::class
        ],
        AssistedPurchaseApprovedEvent::class => [
            NotifyUserAssistedPurchaseApproved::class
        ],
        AssistedPurchaseCanceledEvent::class => [
            NotifyUserAssistedPurchaseCanceled::class
        ],
        AssistedPurchaseFinishedEvent::class => [
            NotifyUserAssistedPurchaseFinished::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
