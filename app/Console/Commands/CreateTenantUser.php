<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTenantUser extends Command
{
    protected $signature = 'tenant:user {tenant_id} {email} {name} {--password=password}';
    protected $description = 'Create a user for a specific tenant';

    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        $email = $this->argument('email');
        $name = $this->argument('name');
        $password = $this->option('password');

        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            $this->error("Tenant '{$tenantId}' bulunamadı!");
            return Command::FAILURE;
        }

        $tenant->run(function() use ($email, $name, $password, $tenantId) {
            // Kullanıcı zaten var mı kontrol et
            if (User::where('email', $email)->exists()) {
                $this->warn("Kullanıcı '{$email}' zaten mevcut!");
                return Command::FAILURE;
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $this->info("✓ Kullanıcı oluşturuldu!");
            $this->info("  Tenant: {$tenantId}");
            $this->info("  Email: {$email}");
            $this->info("  Password: {$password}");
            $this->info("  Database: " . DB::connection()->getDatabaseName());
        });

        return Command::SUCCESS;
    }
}

