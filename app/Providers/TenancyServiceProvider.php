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
        // Tenant oluşturulduğunda otomatik database oluştur
        Event::listen(
            Events\TenantCreated::class,
            Jobs\CreateDatabase::class
        );

        // Tenant oluşturulduğunda otomatik migration çalıştır
        Event::listen(
            Events\TenantCreated::class,
            Jobs\MigrateDatabase::class
        );

        // Tenant silindiğinde database'i de sil
        Event::listen(
            Events\TenantDeleted::class,
            Jobs\DeleteDatabase::class
        );
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
                'switch.tenant.db',  // ← BUNU EKLE (EN SONA!)
            ])
                ->group(base_path('routes/tenant.php'));
        }
    }
}
