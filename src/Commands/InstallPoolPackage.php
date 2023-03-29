<?php

namespace Dimimo\Pool\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallPoolPackage extends Command
{
    protected $signature = 'pool:install';

    protected $description = 'Install the Pool Package';

    public function handle()
    {
        $this->info('Installing the Pool Package...');
        $this->info('Publishing configuration...');
        if (! $this->configExists()) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration(true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }
        $this->info('Installed Pool Package');
    }

    private function configExists(): bool
    {
        return File::exists(config_path('pool.php'));
    }

    private function publishConfiguration($force = false)
    {
        $params = [
            '--provider' => "Dimimo\Pool\PoolServiceProvider",
            '--tag' => 'config',
        ];
        if ($force === true) {
            $params['--force'] = true;
        }
        $this->call('vendor:publish', $params);
    }

    private function shouldOverwriteConfig(): bool
    {
        return $this->confirm('Config file already exists. Do you want to overwrite it?');
    }
}
