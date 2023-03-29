<?php

namespace Dimimo\Pool\Http\Controllers;

use Dimimo\Pool\Models\PoolDate;

trait GetCycles
{
    private function getCycles(int $limit = 4): array
    {
        return PoolDate::select('cycle')->distinct()->orderBy('cycle', 'desc')->limit($limit)->get()->pluck('cycle')->toArray();
    }
}
