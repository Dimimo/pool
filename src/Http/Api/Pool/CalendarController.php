<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers\Api\Pool;

use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Http\Resources\CalendarCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class CalendarController
 *
 * @package Dimimo\Pool\Http\Controllers\Api\Pool
 */
class CalendarController extends PoolController
{
    /**
     * Get the whole calendar of a certain cycle
     *
     * @return CalendarCollection
     */
    public function calendar(): CalendarCollection
    {
        $calendar = PoolDate::cycle()->with([
                                                'events' => function (HasMany $q)
                                                {
                                                    return $q->with(['venue', 'date', 'team_1', 'team_2']);
                                                },
                                            ])->orderBy('date')->get();

        return new CalendarCollection($calendar);
    }
}
