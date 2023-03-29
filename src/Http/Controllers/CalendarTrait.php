<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers;

use Dimimo\Pool\Models\PoolDate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CalendarTrait
{
    /**
     * @return Collection<PoolDate>
     */
    private function getCalendar(): Collection
    {
        return PoolDate::cycle()->with([
                                           'events' => function (HasMany $q)
                                           {
                                               return $q->with(['date', 'team_1', 'team_2']);
                                           },
                                       ])->orderBy('date')->get();
    }
}
