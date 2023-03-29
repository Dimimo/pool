<?php

namespace Dimimo\Pool\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dimimo\Pool\Pool
 */
class Pool extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'pool';
    }
}
