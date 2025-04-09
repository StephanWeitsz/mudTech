<?php

namespace App\Providers;

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
        if (env('CODESPACE_NAME')) {
            $codespaceUrl = 'https://' . env('CODESPACE_NAME') . '-' . env('APP_PORT', '8000') . '.app.github.dev';
            \URL::forceRootUrl($codespaceUrl);      
            // If using HTTPS in Codespace
            if (str_starts_with($codespaceUrl, 'https://')) {
                \URL::forceScheme('https');
            }
        }

    }
}
