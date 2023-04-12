<?php

namespace Dimimo\Pool\Tests;

use Dimimo\Pool\PoolServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected $loadEnvironmentVariables = true;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Dimimo\\Pool\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            PoolServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('database.default', 'testing');

        include_once __DIR__.'/../database/migrations/create_pool_admins_table.php.stub';
        (new \CreatePoolAdminsTable)->up();
        include_once __DIR__.'/../database/migrations/create_pool_dates_table.php.stub';
        (new \CreatePoolDatesTable)->up();
        include_once __DIR__.'/../database/migrations/create_pool_events_table.php.stub';
        (new \CreatePoolEventsTable)->up();
        include_once __DIR__.'/../database/migrations/create_pool_players_table.php.stub';
        (new \CreatePoolPlayersTable)->up();
        include_once __DIR__.'/../database/migrations/create_pool_teams_table.php.stub';
        (new \CreatePoolTeamsTable)->up();
        include_once __DIR__.'/../database/migrations/create_pool_venues_table.php.stub';
        (new \CreatePoolVenuesTable)->up();
    }

    /**
     * Define database migrations.
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();
    }
}
