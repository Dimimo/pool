<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers;

use DateTime;
use Dimimo\Pool\Charts\PoolTeamsChart;
use Dimimo\Pool\Events\ScoreEvent;
use Dimimo\Pool\Jobs\PoolChart;
use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Models\PoolEvent;
use Dimimo\Pool\Models\PoolTeam;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Log;
use Psr\SimpleCache\InvalidArgumentException;

class CycleController extends Controller
{
    use FormBuilderTrait, ResultsTrait, PoolVenueTrait, PoolTeamTrait, PoolPlayerTrait, PoolEventTrait, PoolDateTrait, CalendarTrait;

    /**
     * @return RedirectResponse
     */
    public function login(): RedirectResponse
    {
        if ($this->hasAccess)
        {
            return redirect()->route('pool.index')->with('success', 'You are logged in');
        }

        return redirect()->route('pool.index');
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        auth()->logout();

        return redirect()->route('pool.index')->with('success', 'You have been logged out. Come again :)');
    }

    /**
     * The start page (/pool)
     *
     * @return View
     * @throws InvalidArgumentException
     */
    public function index(): View
    {
        $scores = $this->getResults();
        $week   = $this->getLastWeek();
        $date   = $this->getLastWeek(true);
        $week ? $chart = $this->getCharts() : $chart = null;
        $i        = 1;
        $score_id = null;

        return view('pool::index', compact('scores', 'week', 'date', 'chart', 'i', 'score_id'));
    }

    /**
     * Determine the last played week
     *
     * @param bool $return_date
     *
     * @return int|PoolDate
     */
    private function getLastWeek(bool $return_date = false): int|PoolDate
    {
        $dates      = $this->getCalendar();
        $returnDate = null;
        //if this a brand-new cycle, without events, put week played to 0
        if ( ! count($dates->first()->events))
        {
            return 0;
        }
        $week = 0;
        foreach ($dates as $date)
        {
            if (count($date->events) > 0 && $date->events[0]->score1 !== null)
            {
                $returnDate = $date;
                $week ++;
            }
        }
        if ($return_date)
        {
            return $returnDate;
        }

        return $week;
    }

    /**
     * Get the charts' data. PoolTeamsChart holds the general setup for the global settings
     *
     * @param bool $force
     *
     * @return PoolTeamsChart
     * @throws InvalidArgumentException
     */
    private function getCharts(bool $force = false): PoolTeamsChart
    {
        $cycle = str_replace('/', '-', $this->cycle);
        if ( ! $force && cache()->store('file')->has('pool.chart.' . $cycle))
        {
            return cache()->store('file')->get('pool.chart.' . $cycle);
        }
        $teams     = $this->getTeamsCollection()->pluck('name', 'id')->toArray();
        $chart     = new PoolTeamsChart(count($teams));
        $last_week = (int) $this->getLastWeek();
        $colors    = $this->colors();
        foreach ($teams as $key => $team)
        {
            $teams[$key] = array('name' => $team, 'type' => 'line', 'values' => []);
        }
        $chart->type('line');
        $chart->labels(range(1, $last_week));
        //$chart->formatOptions(true);
        $chart->options(['fill' => false]);
        $chart->height(300)->width(600);
        for ($i = 1 ; $i <= $last_week ; $i ++)
        {
            $scores = $this->getScores($i);
            $j      = 1;
            foreach ($scores as $score)
            {
                $teams[$score['team']->id]['values'][] = $j;
                $j ++;
            }
        }
        foreach ($teams as $team)
        {
            $chart->dataset($team['name'], $team['type'], $team['values']);
        }
        foreach ($chart->datasets as $key => $dataset)
        {
            $dataset->options = ['fill' => false, 'borderColor' => $colors[$key], 'backgroundColor' => $colors[$key]];
        }
        cache()->store('file')->forever('pool.chart.' . $cycle, $chart);

        return $chart;
    }

    /**
     * Get the Teams in the current cycle in alphabetical order
     *
     * @return Collection<PoolTeam>
     */
    private function getTeamsCollection(): Collection
    {
        return PoolTeam::cycle()->with(['venue', 'players'])->where('name', '<>', 'BYE')->orderBy('name')->get();
    }

    /**
     * @param Request $request
     * @param string  $cycle
     *
     * @return RedirectResponse
     */
    public function cycle(Request $request, string $cycle): RedirectResponse
    {
        if ($cycle === '0000/00')
        {
            return redirect()->route('pool.all_seasons');
        }
        $request->session()->put('cycle', $cycle);

        return redirect()->route('pool.index')->with(['success' => 'The season your are viewing is now <strong>' . $cycle . '</strong>']);
    }

    /**
     * Get the colors used for the different teams in charts
     * todo: create 20 different colors, now there are only 14
     *
     * @return array
     */
    private function colors(): array
    {
        return [
            '#f06292',
            '#9c27b0',
            '#7986cb',
            '#00838f',
            '#1b5e20',
            '#9e9d24',
            '#e65100',
            '#ffab91',
            '#78909c',
            '#795548',
            '#00c853',
            '#ff1744',
            '#757575',
            '#ffff00',
        ];
    }

    /**
     * Needed to build up the charts
     *
     * @param int|null $weeks
     *
     * @return \Illuminate\Support\Collection
     */
    private function getScores(?int $weeks = null): \Illuminate\Support\Collection
    {
        $dates = $this->getCalendar();
        if ($weeks)
        {
            $dates = $dates->take($weeks);
        }
        $teams      = $this->getTeamsCollection();
        $max_games  = 0;
        $scores     = collect();
        $collection = collect([
                                  'id'         => null,
                                  'team'       => new PoolTeam(),
                                  'played'     => new PoolTeam(),
                                  'score'      => '',
                                  'won'        => 0,
                                  'lost'       => 0,
                                  'for'        => 0,
                                  'against'    => 0,
                                  'points'     => 0,
                                  'games'      => 0,
                                  'percentage' => 0,
                                  'max_games'  => 0,
                              ]);
        //first we rotate the teams
        foreach ($teams as $team)
        {
            $result         = clone $collection;
            $result['team'] = $team;
            //then we rotate the dates (in chronological order)
            foreach ($dates as $date)
            {
                //check if the date has events
                /** @var PoolDate $date */
                if ($date->events()->count() > 0)
                {
                    //now loop through the events
                    foreach ($date->events as $event)
                    {
                        //check if there are any scores,both can't be null
                        if ( ! is_null($event->score1) && ! is_null($event->score2))
                        {
                            //save the current date, for BYE check later on
                            //$current_date = $date;
                            //check if the team is the home team
                            if ($team->id == $event->team_1->id)
                            {
                                $result['id']      = $event->id;
                                $result['played']  = $event->team_2;
                                $result['for']     = $result['for'] + $event->score1;
                                $result['against'] = $result['against'] + $event->score2;
                                $result['score']   = "$event->score1/$event->score2";
                                if ($event->team_2->name != 'BYE')
                                {
                                    $result['games'] = $result['games'] + 1;
                                    if ($max_games < $result['games'])
                                    {
                                        $max_games = $result['games'];
                                    }
                                }
                                //have they won (all above 7 is a win, even if it's a forfeit)
                                if ($event->score1 > 7)
                                {
                                    $result['won']    = $result['won'] + 1;
                                    $result['points'] = $result['points'] + 4;
                                } //the game is lost
                                else
                                {
                                    if ($event->score2)
                                    {
                                        $result['lost'] = $result['lost'] + 1;
                                    }
                                }
                            } //check of the team is the visiting team
                            else if ($team->id == $event->team_2->id)
                            {
                                $result['id']      = $event->id;
                                $result['played']  = $event->team_1;
                                $result['for']     = $result['for'] + $event->score2;
                                $result['against'] = $result['against'] + $event->score1;
                                $result['score']   = "$event->score2/$event->score1";
                                $result['games']   = $result['games'] + 1;
                                //have they won (all above 7 is a win, even if it's a forfeit)
                                if ($event->score2 > 7)
                                {
                                    $result['won']    = $result['won'] + 1;
                                    $result['points'] = $result['points'] + 4;
                                } //the game is lost
                                else
                                {
                                    if ($event->score1)
                                    {
                                        $result['lost'] = $result['lost'] + 1;
                                    }
                                }
                            }
                        }
                        /*else if ($current_date === $date && $event->team_2->name === 'BYE') {
                            $result['id'] = $event->id;
                            $result['played'] = $event->team_2;
                            $result['score'] = '---';
                        }*/
                    }
                }
            }
            $scores->push($result);
        }
        //at the max_games (the total amount of games, including semi and finals) to each team score array
        $scores->each(function ($score) use ($max_games)
        {
            return $score['max_games'] = $max_games;
        });

        return $scores->sortBy('against')->sortByDesc('for')->sortByDesc('won');
    }

    /**
     * Return a page with all the available seasons, including total games in each season
     *
     * @return View
     * @throws Exception
     */
    public function allSeasons(): View
    {
        $dates = PoolDate::withCount('events')->orderBy('cycle', 'desc')->orderBy('date')->get();
        $list    = [];
        $current = '';
        foreach ($dates as $date)
        {
            if ($date->cycle != $current)
            {
                $current            = $date->cycle;
                $carbon             = Carbon::make(new DateTime($date->date));
                $league             = $carbon->dayName . ' League';
                $season             = $carbon->format('F Y');
                $list[$date->cycle] = ['count' => $date->events_count, 'league' => $league, 'season' => $season];
            } else
            {
                $list[$current]['count'] = (int) $list[$current]['count'] + (int) $date->events_count;
            }
        }

        return view('pool::seasons', compact('list'));
    }

    /**
     * Private functions
     */

    /**
     * Show the participating teams and the venues
     *
     * @return View
     */
    public function teams(): View
    {
        $teams = $this->getTeamsCollection();

        return view('pool::teams', compact('teams'));
    }

    /**
     * Show the season's calendar
     *
     * @return View
     */
    public function calendar(): View
    {
        $dates = $this->getCalendar();

        return view('pool::calendar', compact('dates'));
    }

    /**
     * This is an ajax request from the day score overview. It updates the individual scores.
     * It also triggers the Pusher event
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateScore(Request $request): JsonResponse
    {
        $event         = PoolEvent::findOrFail($request->get('event'));
        $field         = (string) $request->get('field');
        $value         = $request->get('val');
        $old_value     = $event->$field;
        $event->$field = $value;
        $date          = $event->date;
        if ($this->hasAccess)
        {
            $event->update();
            PoolChart::dispatch($this->cycle);
            //only trigger the Pusher event during the time window
            if ($date->checkIfGuestHasWritableAccess())
            {
                ScoreEvent::dispatch($event);
            }
        } else if ($date->checkIfGuestHasWritableAccess())
        {
            $event->update();
            PoolChart::dispatch($this->cycle);
            ScoreEvent::dispatch($event);
        } else
        {
            return response()->json(['type' => 'error', 'message' => 'no access or access is expired']);
        }
        //log the input for reference
        if ($this->hasAccess)
        {
            /** @phpstan-ignore-next-line */
            $ip = auth()->user()->name;
        } else
        {
            $ip = $request->ip();
        }
        Log::info("[PoolChart] ($this->cycle) {$date->date->format('Y-m-d')} [$ip] " . " {$event->team_1->name} - {$event->team_2->name} ($field: $old_value => $value)");

        return response()->json(['type' => 'success', 'data' => $event->toArray()]);
    }

    /**
     * A JSON request from an admin to update the charts
     * Functions also as a queued job: PoolChart::dispatch($this->cycle);
     *
     * @param string|null $cycle
     *
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    public function updateChart(?string $cycle = null): JsonResponse
    {
        if (isset($cycle))
        {
            $this->cycle = $cycle;
            session()->put('cycle', $cycle);
        }
        $this->getCharts(true);

        return response()->json(['type' => 'success']);
    }

    /**
     * For the table when a new score has been added to the day result during the time window
     * This is triggered by Pusher
     *
     * @param Request $request
     *
     * @return string
     */
    public function returnTableUpdate(Request $request): string
    {
        $score_id = $request->get('score_id');
        $scores   = $this->getResults();
        $week     = $this->getLastWeek();
        $date     = $this->getLastWeek(true);
        $i        = 1;

        return view('pool::_scores', compact('scores', 'week', 'date', 'i', 'score_id'))->render();
    }

    /**
     * download the day schedule
     *
     * @param PoolEvent $event
     *
     * @return Response
     */
    public function daySchedule(PoolEvent $event): Response
    {
        if (isset($event->date))
        {
            $filename = $event->date->date->format('Y-m-d') . '_' . Str::slug($event->team_1->name) . '_' . Str::slug($event->team_2->name) . '.pdf';
        } else
        {
            $filename = 'day-schedule.pdf';
        }
        $html = view('pool::day-schedule', compact('event'))->render();
        $pdf  = Pdf::loadHTML($html, 'utf-8');

        return $pdf->download($filename);
    }
}
