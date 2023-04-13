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

        $this->configInstallation();
        $this->viewsInstallation();
        $this->assetsInstallation();
        $this->migrationsInstallation();

        $this->info('The Pool Package is installed. Enjoy!');
    }

    private function configInstallation()
    {
        $this->info('Publishing configuration...');
        if (! File::exists(config_path('pool.php'))) {
            $this->publishTags('config');
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishTags('config', true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }
    }

    private function viewsInstallation()
    {
        $this->info('Publishing views...');
        if (! File::isDirectory(resource_path('views/vendor/pool'))) {
            $this->publishTags('views');
            $this->info('Published views');
        } else {
            if ($this->shouldOverwriteViews()) {
                $this->info('Overwriting view files...');
                $this->publishTags('views', true);
            } else {
                $this->info('Existing views were not overwritten');
            }
        }
    }

    private function assetsInstallation()
    {
        $this->info('Publishing assets...');
        if (! File::exists(public_path('js/pool.js'))) {
            $this->publishTags('assets');
            $this->info('Published assets on public/js');
        } else {
            if ($this->shouldOverwriteAssets()) {
                $this->info('Overwriting asset files...');
                $this->publishTags('assets', true);
            } else {
                $this->info('Existing asset files were not overwritten');
            }
        }
    }

    private function migrationsInstallation()
    {
        if (! class_exists('CreatePoolAdminsTable')) {
            $this->info('Publishing migrations...');
            $this->publishTags('migrations');
            $this->info('Migrations are published');
        }
    }

    private function publishTags($tag, $force = false)
    {
        $params = [
            '--provider' => "Dimimo\Pool\PoolServiceProvider",
            '--tag' => $tag,
        ];
        if ($force === true) {
            $params['--force'] = true;
        }
        $this->call('vendor:publish', $params);
    }

    private function shouldOverwriteConfig(): bool
    {
        return $this->confirm('Config file pool.php already exists. Do you want to overwrite it?');
    }

    private function shouldOverwriteViews(): bool
    {
        return $this->confirm('The resources views already exists. Do you want to overwrite them?');
    }

    private function shouldOverwriteAssets(): bool
    {
        return $this->confirm('The asset files (public/js) already exists. Do you want to overwrite them?');
    }
}
