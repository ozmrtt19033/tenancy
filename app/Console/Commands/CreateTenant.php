<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create {name} {domain}';
    protected $description = 'Create a new tenant with domain';

    public function handle()
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');

        try {
            // Tenant oluştur
            $tenant = Tenant::create([
                'id' => $name,
            ]);

            $this->info("✓ Tenant created: {$tenant->id}");

            // Domain ekle
            $tenant->domains()->create([
                'domain' => $domain,
            ]);

            $this->info("✓ Domain added: {$domain}");
            
            // Database oluştur
            $tenant->database()->makeCredentials();
            $tenant->database()->manager()->createDatabase($tenant);
            $this->info("✓ Database created: tenant{$name}");
            
            // Migration çalıştır - tenant context'inde
            $tenant->run(function () {
                \Artisan::call('migrate', [
                    '--path' => 'database/migrations/tenant',
                    '--force' => true,
                ]);
            });
            $this->info("✓ Migrations completed");

            $this->newLine();
            $this->info("🎉 Tenant successfully created!");
            $port = env('APP_PORT', '8004');
            $this->info("🌐 Access at: http://{$domain}:{$port}");
            $this->info("💡 Don't forget to add '127.0.0.1 {$domain}' to your hosts file!");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("❌ Failed to create tenant: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
