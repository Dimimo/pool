<?php

namespace Dimimo\Pool\Providers;

use Dimimo\Pool\Events\ScoreEvent;
use Dimimo\Pool\Listeners\ScoreEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ScoreEvent::class => [
            ScoreEventListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
