<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        VerifyEmail::$toMailCallback = function($notifiable, $verificationUrl) {
            return (new MailMessage)
                ->subject(Lang::get('Correo de Verificación'))
                ->greeting('Hola, Bienvenido!')
                ->line(Lang::get('Haga clic en el botón de abajo para verificar su dirección de correo electrónico.'))
                ->action(Lang::get('Confirme su dirección de correo electrónico'), $verificationUrl)
                ->line(Lang::get('Si no creó una cuenta, no es necesario realizar ninguna otra acción.'));
        };

        ResetPassword::$toMailCallback = function($notifiable, $token) {
            $url = "http://localhost:8080/system/forgot-password?token={$token}&email={$notifiable->getEmailForPasswordReset()}";
            return (new MailMessage)
                ->subject(Lang::get('Restablecimiento de contraseña'))
                ->greeting("Hola, {$notifiable->getEmailForPasswordReset()}")
                ->line(Lang::get('Le enviamos este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.'))
                ->action(Lang::get('Restablecer la contraseña'), $url)
                ->line(Lang::get('Este enlace de restablecimiento de contraseña caducará en 60 minutos.'))
                ->line(Lang::get('Si no creó una cuenta, no es necesario realizar ninguna otra acción.'));
        };
    }
}
