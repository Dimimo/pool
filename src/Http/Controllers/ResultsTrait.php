<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers;

use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Models\PoolTeam;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Trait ResultsTrait
 *
 * @package App\Http\Controllers\Pool
 */
trait ResultsTrait
{
    /**
     * A placeholder for the team id's
     *
     * @var array $teams
     */
    private array $teams;
    /**
     * the raw values of the teams (natural array)
     *
     * @var array $teams_array
     */
    private array $teams_array;

    /**
     * The big one. Calculates all results for each team and each event.
     *
     * @return array
     */
    private function getResults(): array
    {
        $results = collect();
        $this->getTeamsArray();
        $this->getEvents();
        $max_games = $this->getPlayedWeeks();
        foreach ($this->teams as $team_id => $events)
        {
            $result = $this->startCollection();
            $result->put('team', PoolTeam::find($team_id));
            foreach ($events as $event)
            {
                if ( ! is_null($event->score1) && ! is_null($event->score2) && $event->team_2->name !== 'BYE')
                {
                    $result->put('id', $event->id);
                    $result->put('last_game_won', false);
                    $result->put('games_played', $result->get('games_played') + 1);
                    //team plays home
                    if ($team_id === $event->team_1->id)
                    {
                        $result->put('played', $event->team_2);
                        $result->put('for', $result->get('for') + $event->score1);
                        $result->put('against', $result->get('against') + $event->score2);
                        //in case of not in (0/0)
                        if ($event->score1 == 0 && $event->score2 == 0)
                        {
                            $result->put('last_result', "not in");
                        } else
                        {
                            $result->put('last_result', "$event->score1/$event->score2");
                        }
                        if ($event->score1 > 7)
                        {
                            $result->put('won', $result->get('won') + 1);
                            $result->put('last_game_won', true);
                        } else if ($event->score1 !== 0 && $event->score2 !== 0)
                        { //in case of not-in (0-0)
                            $result->put('lost', $result->get('lost') + 1);
                            $result->put('last_game_won', false);
                        }
                    } //team plays as visitor
                    else if ($team_id === $event->team_2->id)
                    {
                        $result->put('played', $event->team_1);
                        $result->put('for', $result->get('for') + $event->score2);
                        $result->put('against', $result->get('against') + $event->score1);
                        //in case of not in (0/0)
                        if ($event->score1 == 0 && $event->score2 == 0)
                        {
                            $result->put('last_result', "not in");
                        } else
                        {
                            $result->put('last_result', "$event->score2/$event->score1");
                        }
                        if ($event->score2 > 7)
                        {
                            $result->put('won', $result->get('won') + 1);
                            $result->put('last_game_won', true);
                        } else if ($event->score1 !== 0 && $event->score2 !== 0)
                        { //in case of not-in (0-0) which is not a loss
                            $result->put('lost', $result->get('lost') + 1);
                            $result->put('last_game_won', false);
                        }
                    }
                } //HERE is a tricky one, to avoid that the nr 3 is higher ranked than the runner-up
                else if (($event->team_2->name === 'BYE') && ($result->get('games_played') <= ($max_games - 1)))
                {
                    $result->put('games_played', $result->get('games_played') + 1);
                    $result->put('played', $event->team_2);
                    $result->put('last_result', 'BYE');
                }
                if ($max_games < $result->get('games_played'))
                {
                    $max_games ++; // in case of semi and finals
                }
                $result->put('max_games', $max_games);
            }
            $results->push($result);
        }
        //finalize the results collection
        $results->map(function ($result) use ($max_games)
        {
            //in case of (semi) finals, set the last result to false for teams that didn't make it
            if ($max_games > $result->get('games_played'))
            {
                $result->put('last_game_won', false);
            }
            $result->put('max_games', $max_games);
            $result->put('percentage', $this->percentage($result));

            return $result;
        });
        //and sort it by percentage (success rate)
        $results = $results->sortByDesc('percentage', SORT_NATURAL)->values()->all();
        //add the real ranking to the result object
        $rank = 1;
        foreach ($results as $key => $result)
        {
            $result->put('rank', $rank);
            $rank ++;
            $results[$key] = $result;
        }

        return $results;
    }

    /**
     * Get the Teams in the current cycle in alphabetical order
     * Flip it and prepare for the final calculation
     *
     * @return void
     */
    private function getTeamsArray(): void
    {
        $this->teams_array = PoolTeam::cycle()->where('name', '<>', 'BYE')->orderBy('name')->get('id')->pluck('id')->toArray();
        $this->teams       = array_flip($this->teams_array);
        foreach ($this->teams as $id => $team)
        {
            $this->teams[$id] = [];
        }
    }

    /**
     * Get all events, pushes the results in $this->>teams
     *
     * @return void
     */
    private function getEvents(): void
    {
        $dates = PoolDate::cycle()->with('events')->get();
        $dates->each(function (PoolDate $date)
        {
            $date->events->each(function ($event)
            {
                if (in_array($event->team_1->id, $this->teams_array))
                {
                    $this->teams[$event->team_1->id][] = $event;
                }
                if (in_array($event->team_2->id, $this->teams_array))
                {
                    $this->teams[$event->team_2->id][] = $event;
                }
            });
        });
    }

    /**
     * Get the number of played weeks, days not played are omitted
     * This could under-count because of semi and finals, but is fixed in the final calculation
     *
     * @return int
     */
    private function getPlayedWeeks(): int
    {
        $dates = PoolDate::cycle()->with([
                                             'events' => function (HasMany $q)
                                             {
                                                 return $q->with(['venue', 'date', 'team_1', 'team_2']);
                                             },
                                         ])->orderBy('date')->get();
        $week  = 0;
        foreach ($dates as $date)
        {
            if (count($date->events) > 0 && $date->events[0]->score1 !== null)
            {
                $week ++;
            }
        }

        return $week;
    }

    /**
     * Returns a collection, is called for the calculation of every other team in the calculation loop
     *
     * @return Collection
     */
    private function startCollection(): Collection
    {
        $collection = collect();
        $collection->put('id', null);
        $collection->put('team', 'my team');
        $collection->put('played', null);
        $collection->put('won', 0);
        $collection->put('lost', 0);
        $collection->put('for', 0);
        $collection->put('against', 0);
        $collection->put('games_played', 0);
        $collection->put('last_result', '');
        $collection->put('last_game_won', false);
        $collection->put('percentage', 0);
        $collection->put('rank', 0);
        $collection->put('max_games', 0);

        return $collection;
    }

    /**
     * Calculates the percentages of a given score table of a team
     *
     * @param Collection $result
     *
     * @return integer
     */
    public function percentage(Collection $result): int
    {
        if ( ! $result->get('max_games'))
        {
            return 0;
        }

        return (int) number_format(round(((($result->get('won') / $result->get('max_games') * 100) + ($result->get('for') / ($result->get('max_games') * 15)) * 100)) / 2));
    }
}
