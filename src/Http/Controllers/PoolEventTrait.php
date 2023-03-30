<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers;

use Dimimo\Pool\Http\Forms\PoolEventForm;
use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Models\PoolEvent;
use Dimimo\Pool\Models\PoolTeam;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Trait PoolEventTrait
 */
trait PoolEventTrait
{
    public function createEvent(FormBuilder $formBuilder): View|RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $date = PoolDate::cycle()->orderBy('date', 'desc')->first()->pluck('date');
        $form = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolEventForm', [
            'method' => 'POST',
            'url' => route('pool.date.store'),
            'model' => new PoolEvent(['date' => $date, 'cycle' => session('cycle')]),
        ]);
        $form->add('submit', 'submit', ['label' => 'Create a new date', 'attr' => ['class' => 'btn btn-primary']]);

        return view('pool::date-create', compact('form'));
    }

    /**
     * Store the new event (game) and show the day overview
     */
    public function storeEvent(Request $request): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $form = $this->form(PoolEventForm::class);
        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $data = $request->all();
        //automatically set the scores to 0-0 if it's the first playing week to avoid a bug at the overview page
        $team = PoolTeam::findOrFail($data['team1']);
        if (is_null($data['score1']) && is_null($data['score2'])) {
            if ($team->team_1()->count() === 0 && $team->team_2()->count() === 0) {
                $data['score1'] = $data['score2'] = 0;
            }
        }
        $event = new PoolEvent($data);
        $event->save();

        return redirect()->route('pool.date.show', [$event->pool_date_id])->with(['success' => 'The event is created']);
    }

    /**
     * Show the page to edit an existing event (game)
     */
    public function editEvent(FormBuilder $formBuilder, int $id): View|RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $event = PoolEvent::findOrFail($id);
        $form = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolEventForm', [
            'method' => 'PUT',
            'url' => route('pool.event.update', [$event->id]),
            'model' => $event,
        ]);
        $form->add('submit', 'submit', ['label' => 'Update this event', 'attr' => ['class' => 'btn btn-primary']]);

        return view('pool::event-edit', compact('form', 'event'));
    }

    /**
     * Update the existing event
     */
    public function updateEvent(Request $request, int $id): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $form = $this->form(PoolEventForm::class);
        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $event = PoolEvent::findOrFail($id);
        $event->update($request->all());

        return redirect()->route('pool.date.show', [$event->pool_date_id])->with(['success' => 'The event is updated']);
    }

    /**
     * Delete an event (game)
     *
     *
     * @throws Exception
     */
    public function deleteEvent(int $id): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $event = PoolEvent::findOrFail($id);
        $event->delete();

        return redirect()->route('pool.date.show', [$event->pool_date_id])->with(['success' => 'The event is deleted']);
    }
}
