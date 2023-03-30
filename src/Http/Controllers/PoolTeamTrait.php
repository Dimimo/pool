<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers;

use Dimimo\Pool\Http\Forms\PoolTeamForm;
use Dimimo\Pool\Models\PoolEvent;
use Dimimo\Pool\Models\PoolTeam;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Trait PoolTeamTrait
 */
trait PoolTeamTrait
{
    public function showTeam(int $id): View
    {
        $dates = $this->getCalendar();
        $team = PoolTeam::cycle()->with([
            'venue',
            'players' => function (HasMany $q) {
                return $q->orderBy('captain', 'desc')->orderBy('name');
            },
        ])->findOrFail($id);

        return view('pool::team-show', compact('team', 'dates'));
    }

    public function createTeam(FormBuilder $formBuilder, ?int $venue_id = null): View|RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $form = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolTeamForm', [
            'method' => 'POST',
            'url' => route('pool.team.store'),
            'model' => new PoolTeam(['pool_venue_id' => $venue_id, 'cycle' => session('cycle')]),
        ]);
        $form->add('submit', 'submit', ['label' => 'Create this Team', 'attr' => ['class' => 'btn btn-primary']]);

        return view('pool::team-create', compact('form'));
    }

    public function storeTeam(Request $request): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $team = new PoolTeam($request->all());
        //check for uniqueness of the teams name, can't be duplicate
        if ($this->checkTeamNameUnique($team)) {
            return redirect()->back()->withInput()->with(['error' => "The team <strong>$team->name</strong> already exists, has to be unique"]);
        }
        $team->save();

        return redirect()->route('pool.team.show', [$team->id])->with(['success' => 'The Team <strong>'.$team->name.'</strong> has been created']);
    }

    /**
     * Checks if the team name is unique
     */
    private function checkTeamNameUnique(PoolTeam $team): int
    {
        return PoolTeam::cycle()->get()->whereIn('name', [$team->name])->count();
    }

    public function editTeam(FormBuilder $formBuilder, int $id): View|RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $team = PoolTeam::cycle()->with([
            'players' => function (HasMany $q) {
                return $q->orderBy('captain', 'desc')->orderBy('name');
            },
        ])->findOrFail($id);
        $form = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolTeamForm', [
            'method' => 'PUT',
            'url' => route('pool.team.update', [$team->id]),
            'model' => $team,
        ]);
        $form->add('submit', 'submit', ['label' => 'Update this Team', 'attr' => ['class' => 'btn btn-primary']]);

        return view('pool::team-edit', compact('team', 'form'));
    }

    public function updateTeam(Request $request, int $id): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $team = PoolTeam::find($id);
        $form = $this->form(PoolTeamForm::class);
        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        //if the team name changes, check if it already exists somewhere else
        if ($team->name !== $request->get('name')) {
            $team->name = $request->get('name');
            //check for uniqueness of the teams name, can't be duplicate
            if ($this->checkTeamNameUnique($team)) {
                return redirect()->back()->withInput()->with(['error' => "The team <strong>$team->name</strong> already exists, has to be unique"]);
            }
        }
        $team->update($request->all());

        return redirect()->route('pool.teams')->with(['success' => 'The team <strong>'.$team->name.'</strong> is successfully updated']);
    }

    /**
     * Delete a team, check for events first
     */
    public function deleteTeam(int $id): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $team = PoolTeam::find($id);
        if ($this->checkTeamHasEvents($team)) {
            return redirect()->back()->with(['error' => "The team <strong>$team->name</strong> can't be deleted, it still has games in this season."]);
        }
        $team->delete();

        return redirect()->route('pool.teams')->with(['success' => "The team <strong>$team->name</strong> has been deleted"]);
    }

    /**
     * Checks if the team has games
     */
    private function checkTeamHasEvents(PoolTeam $team): int
    {
        return PoolEvent::where('team1', $team->id)->orWhere('team2', $team->id)->count();
    }
}
