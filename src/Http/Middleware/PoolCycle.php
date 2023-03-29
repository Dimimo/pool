<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Middleware;

use Dimimo\Pool\Models\PoolDate;
use Closure;
use DB;
use Illuminate\Http\Request;

/**
 * Class PoolCycle
 *
 * @package App\Http\Middleware
 */
class PoolCycle
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ( ! $request->session()->exists('cycle') || is_null($request->session()->get('cycle')))
        {
            //when no cycle is in the session, put the most recent date cycle as a starting point
            $recent_date = DB::table('pool_dates')->orderBy('cycle', 'desc')->first();
            /** @var PoolDate $recent_date */
            $request->session()->put('cycle', $recent_date->cycle);
        }

        return $next($request);
    }
}
