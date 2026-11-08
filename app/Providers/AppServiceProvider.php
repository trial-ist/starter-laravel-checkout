<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // The workspace preview is served over HTTPS.
        if (request()->header('X-Forwarded-Scheme') === 'https') {
            URL::forceScheme('https');
        }
    }
}
