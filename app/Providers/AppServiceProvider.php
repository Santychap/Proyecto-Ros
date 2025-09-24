<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar el servicio del restaurante
        $this->app->singleton(\App\Services\RestauranteService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Personalizar la notificación de restablecimiento de contraseña
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return url(route('password.reset', [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ], false));
        });

        // Configurar zona horaria desde config
        if (config('app.timezone')) {
            date_default_timezone_set(config('app.timezone'));
        }
    }
}
