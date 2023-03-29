<?php

namespace Dimimo\Pool;

use Dimimo\Pool\Commands\InstallPoolPackage;
use Dimimo\Pool\Commands\PoolScoresSetDay;
use Dimimo\Pool\Http\Middleware\PoolCycle;
use Dimimo\Pool\Providers\EventServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PoolServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->bind('pool', function () {
            return new Pool();
        });
        $this->mergeConfigFrom(__DIR__ . '/../config/pool.php', 'pool');
        // Register the events
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * @throws BindingResolutionException
     */
    public function boot()
    {
        //$this->pushMiddleware(PoolCycle::class);
        if ($this->app->runningInConsole()) {
            // Publish config
            $this->publishes([__DIR__ . '/../config/pool.php' => config_path('pool.php'),], 'config');
            // Publish views
            $this->publishes([__DIR__ . '/../resources/views' => resource_path('views/vendor/pool'),], 'views');
            // Publish assets
            $this->publishes([__DIR__ . '/../resources/assets' => public_path('pool'),], 'assets');
            // Publish commands
            $this->commands([InstallPoolPackage::class, PoolScoresSetDay::class,]);
            // Schedule the command if we are using the application via the CLI
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command('pool:scores')->dailyAt('12:00');
            });
            // Export the migration
            if (!class_exists('CreatePoolAdminsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_pool_admins_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pool_admins_table.php'),
                    __DIR__ . '/../database/migrations/create_pool_dates_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pool_dates_table.php'),
                    __DIR__ . '/../database/migrations/create_pool_events_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pool_events_table.php'),
                    __DIR__ . '/../database/migrations/create_pool_players_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pool_players_table.php'),
                    __DIR__ . '/../database/migrations/create_pool_scores_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pool_scores_table.php'),
                    __DIR__ . '/../database/migrations/create_pool_teams_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pool_teams_table.php'),
                    __DIR__ . '/../database/migrations/create_pool_venues_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pool_venues_table.php'),
                ], 'migrations');
            }
        }
        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'pool');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('PoolCycle', PoolCycle::class);
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('pool.prefix'),
            'middleware' => config('pool.middleware'),
        ];
    }
}
