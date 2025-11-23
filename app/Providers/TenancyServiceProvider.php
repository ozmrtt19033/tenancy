<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class TenancyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Tenant model'i bind et
        $this->app->bind(
            \Stancl\Tenancy\Contracts\TenantWithDatabase::class,
            \App\Models\Tenant::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootEvents();
        $this->mapTenantRoutes();
    }

    /**
     * Tenant event'lerini dinle
     */
    protected function bootEvents()
    {
        // Event listener'ları kaldırdık - tenant oluşturma işlemi komut içinde manuel yapılıyor
        // Çünkü Job'lar queue gerektiriyor ve sync çalışması için komut içinde çağrılıyor
    }

    /**
     * Tenant route'larını yükle
     * WEB MIDDLEWARE İLE BİRLİKTE!
     */
    protected function mapTenantRoutes()
    {
        if (file_exists(base_path('routes/tenant.php'))) {
            Route::middleware([
                'web',
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
            ])
                ->group(base_path('routes/tenant.php'));
        }
    }
}
