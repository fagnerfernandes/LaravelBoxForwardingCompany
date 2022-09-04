<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->greeting('Olá')
                ->subject('Verificar endereço de e-mail')
                ->line('Clique no botão abaixo para verificar seu endereço de e-mail.')
                ->action('Verificar endereço de e-mail', $url)
                ->salutation('Equipe COMPANY')
                ->line('Se você não criou uma conta, nenhuma ação adicional é necessária.');
        });

        $this->registerPolicies();
    }
}
