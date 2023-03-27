<?php

namespace Dimimo\Pool\Pool\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dimimo\Pool\Pool\Pool
 */
class Pool extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Dimimo\Pool\Pool\Pool::class;
    }
}
