<?php

namespace Dimimo\Pool\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        Route::pattern('cycle', '([\d]{4}\/[\d]{2})'); //the pool cycle pattern f.ex. 2018/11

        parent::boot();
    }
}
