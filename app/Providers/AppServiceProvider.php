<?php

namespace App\Providers;

use storage;
use Carbon\CarbonInterval;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(resource_path('views/layouts'), 'layouts');
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(resource_path('views/components'), 'components');
        Passport::loadKeysFrom(storage_path());
        Passport::enablePasswordGrant();
        Passport::tokensExpireIn(now()->addMinutes(60));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));

        // Enregistrer l'observateur d'utilisateur
        \App\Models\User::observe(\App\Observers\UserObserver::class);
    }
}
