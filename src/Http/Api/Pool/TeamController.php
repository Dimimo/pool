<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers\Api\Pool;

use Dimimo\Pool\Http\Controllers\CalendarTrait;
use Dimimo\Pool\Http\Resources\TeamCollection;
use Dimimo\Pool\Http\Resources\TeamSchedule as TeamScheduleResource;
use Dimimo\Pool\Models\PoolTeam;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class TeamController
 */
class TeamController extends PoolController
{
    use CalendarTrait;

    /**
     * Collect all teams with venue and players for the chosen season
     */
    public function index(): TeamCollection
    {
        $teams = PoolTeam::cycle()->where('name', '<>', 'BYE')->with(['venue', 'players'])->orderBy('name')->get();

        return new TeamCollection($teams);
    }

    /**
     * Show the team, address, players and schedule (calendar)
     */
    public function show(int $team_id): TeamScheduleResource
    {
        $calendar = $this->getSchedule($team_id);
        $team = PoolTeam::with([
            'venue',
            'players' => function (HasMany $q) {
                return $q->orderBy('captain', 'desc')->orderBy('name');
            },
        ])->findOrFail($team_id);
        $calendar->prepend($team);

        return new TeamScheduleResource($calendar);
    }

    /**
     * Get the calendar for the specific team, filter out the respective data
     */
    private function getSchedule(int $team_id): Collection
    {
        $dates = $this->getCalendar();
        $calendar = collect();
        foreach ($dates as $date) {
            foreach ($date->events as $event) {
                if ($event->team_1->id === $team_id || $event->team_2->id === $team_id) {
                    $calendar->push($event);
                }
            }
        }

        return $calendar;
    }
}
