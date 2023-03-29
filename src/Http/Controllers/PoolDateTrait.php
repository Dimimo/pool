<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers;

use Dimimo\Pool\Http\Forms\PoolDateForm;
use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Models\PoolEvent;
use Dimimo\Pool\Models\PoolPlayer;
use Dimimo\Pool\Models\PoolTeam;
use Dimimo\Pool\Models\PoolVenue;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Session;

/**
 * Trait PoolDateTrait
 *
 * @package App\Http\Controllers\Pool
 */
trait PoolDateTrait
{
    /**
     * @param FormBuilder $formBuilder
     * @param             $id
     *
     * @return View
     */
    public function showDate(FormBuilder $formBuilder, $id): View
    {
        $date = PoolDate::with('events')->find($id);
        /** @var PoolDate $date */
        if ($date->cycle != session('cycle'))
        {
            session()->put('cycle', $date->cycle);
        }
        $teams = PoolTeam::cycle()->orderBy('name')->get()->pluck('pool_venue_id', 'id')->toJson();
        $form = $formBuilder->create('App\Http\Forms\PoolEventForm', [
            'method' => 'POST',
            'url'    => route('pool.event.store'),
            'model'  => new PoolEvent(['cycle' => session('cycle'), 'pool_date_id' => $date->id]),
        ]);
        $form->add('submit', 'submit', [
                               'label' => 'Create this day event',
                               'attr'  => ['class' => 'btn btn-primary'],
                           ]);

        return view('pool::date-show', compact('date', 'form', 'teams'));
    }

    /**
     * @param FormBuilder $formBuilder
     *
     * @return RedirectResponse|View
     */
    public function createDate(FormBuilder $formBuilder): View|RedirectResponse
    {
        if ( ! $this->hasAccess)
        {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $form = $formBuilder->create('App\Http\Forms\PoolDateForm', [
            'method' => 'POST',
            'url'    => route('pool.date.store'),
            'model'  => new PoolDate(['regular' => '0', 'cycle' => session('cycle')]),
        ]);
        $form->add('submit', 'submit', [
                               'label' => 'Create a new date',
                               'attr'  => ['class' => 'btn btn-primary'],
                           ]);

        return view('pool::date-create', compact('form'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function storeDate(Request $request): RedirectResponse
    {
        if ( ! $this->hasAccess)
        {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $form = $this->form(PoolDateForm::class);
        if ( ! $form->isValid())
        {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $date = new PoolDate($request->all());
        //if it's a new season, send to a new page to select the teams
        if ( ! empty($request->get('new_cycle')))
        {
            $date->cycle = $request->get('new_cycle');
            $date->save();

            return redirect()->route('pool.new_season', [$date->id])->with(['success' => "A new season $date->cycle has been created"]);
        }
        $date->save();

        return redirect()->route('pool.date.show', [$date->id])
            ->with(['success' => 'The new playing date <strong>' . $date->date->format('Y-m-d') . '</strong> is created',]);
    }

    /**
     * Create a new season, select the teams from the previous seasons to facilitate the process
     *
     * @param int $id
     *
     * @return RedirectResponse|View
     */
    public function newSeason(int $id): View|RedirectResponse
    {
        if ( ! $this->hasAccess)
        {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $date  = PoolDate::findOrFail($id);
        $teams = PoolTeam::where('name', '<>', 'BYE')->with([
                                                                'venue',
                                                                'players' => function (HasMany $player)
                                                                {
                                                                    return $player->where('captain', '1')->first();
                                                                },
                                                            ])->latest('id')->take(20)->get()->unique('name')->sortBy('name')->sortByDesc('cycle');
        $venues = PoolVenue::where('name', '<>', 'BYE')->orderBy('name')->pluck('name', 'id')->toArray();
        $venues = ['-- select --'] + $venues;

        return view('pool::new_season', compact('date', 'teams', 'venues'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function newSeasonCreate(Request $request): RedirectResponse
    {
        if ( ! $this->hasAccess)
        {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $cycle = $request->get('cycle');
        $date  = PoolDate::find($request->get('date'));
        $teams = $request->get('team');
        Session::put('cycle', $cycle);
        $venues = $request->get('pool_venue_id');
        //check if new teams are added
        foreach ($request->get('name') as $i => $name)
        {
            if ( ! $name)
            {
                continue;
            }
            $venue = PoolVenue::find($venues[$i]);
            if ( ! $venue)
            {
                return redirect()->back()->withInput()->with(['error' => "The team <strong>$name</strong> has no venue, please choose one"]);
            }
            $new_team = new PoolTeam([
                                         'name'          => $name,
                                         'pool_venue_id' => $venue->id,
                                         'cycle'         => $cycle,
                                     ]);
            $new_team->save();
        }
        //add the selected teams from previous seasons
        foreach ($teams as $id => $i)
        {
            $team     = $this->getTeamWithCaptain($id);
            $new_team = new PoolTeam([
                                         'name'          => $team->name,
                                         'pool_venue_id' => $team->pool_venue_id,
                                         'cycle'         => $cycle,
                                         'remark'        => $team->remark,
                                     ]);
            $new_team->save();
            //also, copy the captain information
            $captain = $team->players->first();
            if ($captain)
            {
                $player = new PoolPlayer([
                                             'name'         => $captain->name,
                                             'gender'       => $captain->gender,
                                             'pool_team_id' => $new_team->id,
                                             'captain'      => 1,
                                             'contact_nr'   => $captain->contact_nr,
                                             'cycle'        => $cycle,
                                         ]);
                $player->save();
            }
        }
        //check if a BYE is needed
        if ($request->get('bye'))
        {
            $venue    = PoolVenue::where('name', 'BYE')->first();
            $bye_team = new PoolTeam([
                                         'name'          => 'BYE',
                                         'pool_venue_id' => $venue->id,
                                         'cycle'         => $cycle,
                                     ]);
            $bye_team->save();
        }

        return redirect()->route('pool.date.show', [$date->id])->with([
                                                                          'success' => count($teams) . ' new teams have been added. The new playing date is <strong>' . $date->date->format('Y-m-d') . '</strong>',
                                                                      ]);
    }

    /**
     * @param $id
     *
     * @return PoolTeam
     */
    private function getTeamWithCaptain($id): PoolTeam
    {
        /** @phpstan-ignore-next-line */
        return PoolTeam::with([
                                  'players' => function (HasMany $q)
                                  {
                                      return $q->where('captain', 1)->get();
                                  },
                              ])->where('id', $id)->get()->first();
    }

    /**
     * Edit a playing date, this will also shift all games (events) to another date
     *
     * @param FormBuilder $formBuilder
     * @param int         $id
     *
     * @return RedirectResponse|View
     */
    public function editDate(FormBuilder $formBuilder, int $id): View|RedirectResponse
    {
        if ( ! $this->hasAccess)
        {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $date = PoolDate::findOrFail($id);
        $form = $formBuilder->create('App\Http\Forms\PoolDateForm', [
            'method' => 'POST',
            'url'    => route('pool.date.update'),
            'model'  => $date,
        ]);
        $form->add('submit', 'submit', ['label' => 'Edit this date', 'attr' => ['class' => 'btn btn-primary']]);

        return view('pool::date-update', compact('form', 'date'));
    }

    /**
     * Update the date in the database, it is also possible a date is requested to be deleted
     *
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateDate(Request $request, int $id): RedirectResponse
    {
        if ( ! $this->hasAccess)
        {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        //first we work with the input, make it a one dimensional array
        $data = array_slice($request->all(), 2, 6, true);
        $val  = array();
        //Build up the values from $key[$id]
        foreach ($data as $k => $v)
        {
            $val[$k] = $v[$id];
        }
        //check if the regular key exists, if not, set it to '0' (laravel bug with unchecked checkboxes)
        array_key_exists('regular', $val) ? : $val['regular'] = '0';
        $date = PoolDate::findOrFail($id);
        //check if it is a delete request
        if (isset($val['delete']) && $val['delete'] == '1')
        {
            if ($date->events()->count() > 0)
            {
                return redirect()->route('pool.dates.edit')
                    ->with(['warning' => 'The date ' . $date->date->format('Y-m-d') . ' can\' be deleted, it has games!']);
            }
            $date->delete();

            return redirect()->route('pool.index')->with(['success' => 'The date ' . $date->date->format('Y-m-d') . ' has been deleted']);
        }
        //check if the date already exists
        if ($date->date->format('Y-m-d') != $val['date'] && PoolDate::where('date', $val['date'])->first())
        {
            return redirect()->back()->with(['warning' => "The date {$val['date']} already exists, please start with the latest dates"]);
        }
        //update the database
        $date->update($val);

        return redirect()->route('pool.dates.edit')->with(['success' => 'The date <strong>' . $date->date->format('Y-m-d') . '</strong> has been updated',]);
    }

    /**
     * Delete a date. Only dates without events can be deleted.
     *
     * @param int $id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteDate(int $id): RedirectResponse
    {
        if ( ! $this->hasAccess)
        {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $date = PoolDate::findOrFail($id);
        if ($date->events()->count())
        {

            return redirect()->route('pool.date.show', [$date->id])
                ->with(['warning' => 'This date <strong>' . $date->date . '</strong> can not be deleted because it has games.']);
        }
        $date->delete();

        return redirect()->route('pool.index')->with(['success' => 'The date ' . $date->date . ' has been deleted']);
    }

    /**
     * Show the forms of all dates, including the empty ones. If empty, a delete button is added
     *
     * @param FormBuilder $formBuilder
     *
     * @return RedirectResponse|View
     */
    public function editDates(FormBuilder $formBuilder): View|RedirectResponse
    {
        if ( ! $this->hasAccess)
        {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $dates = $this->getCalendar();
        $forms = collect();
        foreach ($dates as $date)
        {
            $form = $formBuilder->create('App\Http\Forms\PoolDatesForm', [
                'method' => 'PUT',
                'class'  => 'form-inline',
                'url'    => route('pool.date.update', [$date->id]),
                'model'  => $date,
            ]);
            $forms->push($form);
        }
        if ( ! isset($date))
        {
            $date = new PoolDate();
        }

        return view('pool::dates-edit', compact('forms', 'date'));
    }
}
