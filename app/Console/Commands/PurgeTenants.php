<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class PurgeTenants extends Command
{
    protected $signature = 'tenants:purge';
    protected $description = 'Delete all tenants (dangerous!)';

    public function handle()
    {
        $count = Tenant::count();

        if ($count === 0) {
            $this->info('No tenants to delete.');
            return Command::SUCCESS;
        }

        $this->warn("⚠️  You are about to delete {$count} tenant(s)!");

        if ($this->confirm('Are you absolutely sure?')) {
            Tenant::all()->each(function($tenant) {
                $this->line("Deleting: {$tenant->id}");
                $tenant->delete();
            });

            $this->info("✓ All tenants deleted!");
        } else {
            $this->info("Operation cancelled.");
        }

        return Command::SUCCESS;
    }
}
