<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
    * Register services.
    */
    public function register(): void
    {
        //
    }

    /**
    * Bootstrap services.
    */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
        // Aqui você cria a URL do seu frontend com os parâmetros necessários
        $frontendUrl = "https://meu-app.com/verify-email?url=" . urlencode($url);

        return (new MailMessage)
            ->subject('Verifique seu E-mail')
            ->line('Clique no botão abaixo para verificar seu endereço de e-mail.')
            ->action('Verificar E-mail', $frontendUrl);
    });
    }
}
