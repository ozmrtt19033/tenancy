<?php

use Illuminate\Support\Facades\Route;
use App\Models\Tenant;

/*
|--------------------------------------------------------------------------
| Merkezi Web Routes
|--------------------------------------------------------------------------
| Bu route'lar tenant olmadan çalışır (127.0.0.1:8004)
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
        'domain' => [
            'required',
            'unique:domains,domain',
            function ($attribute, $value, $fail) {
                // Domain formatını kontrol et - .localhost.com yerine .localhost olmalı
                if (str_ends_with($value, '.localhost.com')) {
                    $fail('Domain formatı yanlış! Lütfen .localhost.com yerine .localhost kullanın (örn: can.localhost)');
                }
            },
        ],
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

        // Database oluştur
        $tenant->database()->makeCredentials();
        $tenant->database()->manager()->createDatabase($tenant);

        // Migration çalıştır - doğrudan tenant veritabanına bağlanarak
        $dbName = 'tenant' . $validated['name'];
        $connectionName = 'tenant_temp_' . $validated['name'];
        
        // Geçici connection oluştur
        \Illuminate\Support\Facades\Config::set('database.connections.' . $connectionName, [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $dbName,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);
        
        \Illuminate\Support\Facades\DB::purge($connectionName);
        
        // Migration'ları çalıştır
        \Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--force' => true,
            '--database' => $connectionName,
        ]);

        // Hosts dosyasına domain eklemeyi dene (admin yetkisi gerekebilir)
        $hostsAdded = false;
        try {
            \Artisan::call('tenant:add-hosts', [
                'domain' => $validated['domain'],
            ]);
            $hostsAdded = true;
        } catch (\Exception $e) {
            // Hosts dosyasına yazma başarısız olabilir (admin yetkisi gerekebilir)
            // Kullanıcıya manuel ekleme talimatı verilecek
        }

        $port = env('APP_PORT', '8004');
        $successMessage = "✅ Tenant '{$validated['name']}' başarıyla oluşturuldu! Veritabanı ve tablolar hazır.";
        
        if (!$hostsAdded) {
            $successMessage .= "\n\n⚠️ Hosts dosyasına domain eklenemedi. Lütfen manuel olarak ekleyin:";
            $successMessage .= "\n   1. Notepad'i YÖNETİCİ OLARAK açın";
            $successMessage .= "\n   2. C:\\Windows\\System32\\drivers\\etc\\hosts dosyasını açın";
            $successMessage .= "\n   3. Şu satırı ekleyin: 127.0.0.1 {$validated['domain']}";
            $successMessage .= "\n   4. Kaydedin ve tarayıcıyı yenileyin";
            $successMessage .= "\n\n   Veya şu komutu çalıştırın: php artisan tenant:add-hosts {$validated['domain']}";
        } else {
            $successMessage .= "\n\n✓ Domain hosts dosyasına eklendi!";
        }
        
        $successMessage .= "\n\n🌐 Erişim: http://{$validated['domain']}:{$port}";

        return redirect()->route('tenants.index')
            ->with('success', $successMessage);

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

// Auth routes (merkezi uygulama için - opsiyonel)
// Auth::routes();
