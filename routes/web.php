<?php

use Illuminate\Support\Facades\Route;
use App\Models\Tenant;

/*
|--------------------------------------------------------------------------
| Merkezi Web Routes
|--------------------------------------------------------------------------
| Bu route'lar tenant olmadan çalışır (127.0.0.1:8000)
*/

// Ana sayfa
Route::get('/', function () {
    return view('central.home');
})->name('home');

// Tenant listesi
Route::get('/tenants', function () {
    $tenants = Tenant::with('domains')->get();
    return view('central.tenants', compact('tenants'));
})->name('tenants.index');

// Tenant oluşturma formu
Route::get('/tenants/create', function () {
    return view('central.create-tenant');
})->name('tenants.create');

// Tenant oluşturma işlemi
Route::post('/tenants', function () {
    $validated = request()->validate([
        'name' => 'required|alpha_dash|unique:tenants,id',
        'domain' => 'required|unique:domains,domain',
    ]);

    try {
        // Tenant oluştur
        $tenant = Tenant::create([
            'id' => $validated['name'],
        ]);

        // Domain ekle
        $tenant->domains()->create([
            'domain' => $validated['domain'],
        ]);

        return redirect()->route('tenants.index')
            ->with('success', "✅ Tenant '{$validated['name']}' başarıyla oluşturuldu!");

    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
})->name('tenants.store');

// Tenant silme
Route::delete('/tenants/{tenant}', function (Tenant $tenant) {
    try {
        $tenant->delete();
        return redirect()->route('tenants.index')
            ->with('success', "✅ Tenant '{$tenant->id}' başarıyla silindi!");
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
})->name('tenants.destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
