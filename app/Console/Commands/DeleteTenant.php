<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class DeleteTenant extends Command
{
    protected $signature = 'tenant:delete {id}';
    protected $description = 'Delete a tenant and its database';

    public function handle()
    {
        $id = $this->argument('id');

        $tenant = Tenant::find($id);

        if (!$tenant) {
            $this->error("❌ Tenant '{$id}' not found!");
            return Command::FAILURE;
        }

        $this->warn("⚠️  You are about to delete:");
        $this->line("   Tenant ID: {$tenant->id}");
        $this->line("   Database: {$tenant->tenancy_db_name}");
        $this->line("   Domains: " . $tenant->domains->pluck('domain')->implode(', '));
        $this->newLine();

        if ($this->confirm("Are you sure?")) {
            $tenant->delete();
            $this->info("✓ Tenant '{$id}' deleted successfully!");
            $this->info("✓ Database 'tenant{$id}' deleted!");
        } else {
            $this->info("Operation cancelled.");
        }

        return Command::SUCCESS;
    }
}
