<?php

namespace Dimimo\Pool\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Dimimo\Pool\Events\ScoreEvent;
use Dimimo\Pool\Listeners\ScoreEventListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ScoreEvent::class => [
            ScoreEventListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }
}
