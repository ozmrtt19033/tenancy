<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Listeners;
use Stancl\Tenancy\Middleware;

class TenancyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->bootEvents();
        $this->mapRoutes();
    }

    protected function bootEvents()
    {
        Event::listen(
            Events\TenantCreated::class,
            Jobs\CreateDatabase::class
        );

        Event::listen(
            Events\TenantCreated::class,
            Jobs\MigrateDatabase::class
        );

        Event::listen(
            Events\TenantDeleted::class,
            Jobs\DeleteDatabase::class
        );
    }

    protected function mapRoutes()
    {
        if (file_exists(base_path('routes/tenant.php'))) {
            Route::namespace(null)
                ->group(base_path('routes/tenant.php'));
        }
    }
}
