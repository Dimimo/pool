<?php

namespace Dimimo\Pool\Pool;

use Dimimo\Pool\Pool\Commands\PoolCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PoolServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('pool')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_pool_table')
            ->hasCommand(PoolCommand::class);
    }
}
