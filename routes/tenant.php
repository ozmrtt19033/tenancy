<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        return view('tenant.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('tenant.dashboard');
    });

    Route::get('/users', function () {
        return view('tenant.users');
    });

    Route::get('/reports', function () {
        return view('tenant.reports');
    });

    Route::get('/settings', function () {
        return view('tenant.settings');
    });

    Route::get('/profile', function () {
        return view('tenant.profile');
    });

    Route::get('/test', function () {
        return 'Tenant: ' . tenant('id') . ' - Working!';
    });
});
