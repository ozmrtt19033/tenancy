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
            $this->info("✓ Database: tenant{$name}");

            $this->newLine();
            $this->info("🎉 Tenant successfully created!");
            $this->info("🌐 Access at: http://{$domain}:8000");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("❌ Failed to create tenant: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
