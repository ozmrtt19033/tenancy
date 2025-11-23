<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
        
        // Tenant context'inde session cookie domain'ini tenant domain'ine göre ayarla
        if (tenancy()->initialized) {
            $tenant = tenant();
            if ($tenant && $tenant->domains->isNotEmpty()) {
                $domain = $tenant->domains->first()->domain;
                config(['session.domain' => $domain]);
                config(['session.cookie' => 'laravel_session_' . $tenant->id]);
            }
        }
    }
}
