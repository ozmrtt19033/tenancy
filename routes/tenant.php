<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
| Bu route'lar sadece tenant domain'lerinde çalışır
| Örn: acme.localhost, company1.localhost
*/

// AUTH ROUTES (Laravel UI tarafından oluşturulur)
Auth::routes();

// Ana sayfa - giriş yapmamışsa login'e yönlendir
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

// AUTH REQUIRED - Sadece giriş yapmış kullanıcılar erişebilir
Route::middleware('auth')->group(function () {

    // Dashboard/Home
    Route::get('/home', function () {
        return view('tenant.dashboard');
    })->name('home');

    // Dashboard alternatif route
    Route::get('/dashboard', function () {
        return view('tenant.dashboard');
    })->name('dashboard');

    // Kullanıcılar
    Route::get('/users', function () {
        $users = \App\Models\User::all();
        return view('tenant.users', compact('users'));
    })->name('users.index');
    
    // Kullanıcı düzenleme
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    // Raporlar
    Route::get('/reports', function () {
        return view('tenant.reports');
    })->name('reports');

    // Ayarlar
    Route::get('/settings', function () {
        return view('tenant.settings');
    })->name('settings');
});

