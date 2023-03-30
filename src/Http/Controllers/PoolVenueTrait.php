<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers;

use Dimimo\Pool\Http\Forms\PoolVenueForm;
use Dimimo\Pool\Models\PoolVenue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Trait PoolVenueTrait
 */
trait PoolVenueTrait
{
    public function showVenue(int $id): View
    {
        $venue = PoolVenue::with([
            'teams.players' => function ($q) {
                return $q->cycle()->orderBy('captain', 'desc')->orderBy('name');
            },
        ])->findOrFail($id);

        return view('pool::venue-show', compact('venue'));
    }

    public function createVenue(FormBuilder $formBuilder): View|RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $form = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolVenueForm', [
            'method' => 'POST',
            'url' => route('pool.venue.store'),
            'model' => new PoolVenue(),
        ]);
        $form->add('submit', 'submit', ['label' => 'Create this Venue', 'attr' => ['class' => 'btn btn-primary']]);

        return view('pool::venue-create', compact('form'));
    }

    public function storeVenue(Request $request): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $venue = new PoolVenue($request->all());
        $venue->save();

        return redirect()->route('pool.venue.show', [$venue->id])->with(['success' => 'The Venue <strong>'.$venue->name.'</strong> has been created']);
    }

    public function editVenue(FormBuilder $formBuilder, int $id): View|RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $venue = PoolVenue::findOrFail($id);
        $form = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolVenueForm', [
            'method' => 'PUT',
            'url' => route('pool.venue.update', [$venue->id]),
            'model' => $venue,
        ]);
        $form->add('submit', 'submit', ['label' => 'Update the venue '.$venue->name, 'attr' => ['class' => 'btn btn-primary']]);

        return view('pool::venue-edit', compact('venue', 'form'));
    }

    public function updateVenue(Request $request, int $id): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $venue = PoolVenue::find($id);
        $form = $this->form(PoolVenueForm::class);
        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $venue->update($request->all());

        return redirect()->route('pool.index')->with(['success' => 'The venue <strong>'.$venue->name.'</strong> is successfully updated']);
    }
}
