<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddDomainToHosts extends Command
{
    protected $signature = 'tenant:add-hosts {domain}';
    protected $description = 'Add tenant domain to hosts file';

    public function handle()
    {
        $domain = $this->argument('domain');
        $hostsPath = 'C:\Windows\System32\drivers\etc\hosts';
        $entry = "127.0.0.1 {$domain}";

        if (!file_exists($hostsPath)) {
            $this->error("Hosts file not found at: {$hostsPath}");
            return Command::FAILURE;
        }

        try {
            $content = file_get_contents($hostsPath);
            
            // Check if domain already exists
            if (strpos($content, $domain) !== false) {
                $this->info("✓ Domain '{$domain}' already exists in hosts file");
                return Command::SUCCESS;
            }

            // Add domain to hosts file
            file_put_contents($hostsPath, "\n{$entry}", FILE_APPEND | LOCK_EX);
            
            $this->info("✓ Domain '{$domain}' added to hosts file");
            $this->info("💡 Run 'ipconfig /flushdns' to clear DNS cache");
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to add domain to hosts file: " . $e->getMessage());
            $this->warn("You may need to run this command as administrator");
            return Command::FAILURE;
        }
    }
}

