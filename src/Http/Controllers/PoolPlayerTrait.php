<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Controllers;

use Dimimo\Pool\Http\Forms\PoolPlayerForm;
use Dimimo\Pool\Models\PoolPlayer;
use Dimimo\Pool\Models\PoolTeam;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Trait PoolPlayerTrait
 */
trait PoolPlayerTrait
{
    public function createPlayer(FormBuilder $formBuilder): View|RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $form = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolPlayerForm', [
            'method' => 'POST',
            'url' => route('pool.player.store'),
            'model' => new PoolPlayer(['cycle' => session('cycle')]),
        ]);
        $form->add('submit', 'submit', ['label' => 'Create this player', 'attr' => ['class' => 'btn btn-primary']]);

        return view('pool::player-create', compact('form'));
    }

    public function storePlayer(Request $request): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $form = $this->form(PoolPlayerForm::class);
        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $player = new PoolPlayer($request->all());
        $player->save();

        return redirect()->route('pool.players.edit', [$player->team->id])
            ->with(['success' => 'The player <strong>'.$player->name.'</strong> has been created']);
    }

    public function editPlayers(FormBuilder $formBuilder, int $team): View|RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $team = PoolTeam::cycle()->with([
            'players' => function ($q) {
                return $q->orderBy('captain', 'desc')->orderBy('name', 'asc');
            },
        ])->findOrFail($team);
        $new = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolPlayerForm', [
            'method' => 'POST',
            'url' => route('pool.player.store'),
            'model' => new PoolPlayer(['pool_team_id' => $team->id, 'cycle' => session('cycle')]),
        ]);
        $new->add('submit', 'submit', ['label' => 'Create this player', 'attr' => ['class' => 'btn btn-primary']]);
        $forms = collect();
        foreach ($team->players as $player) {
            $form = $formBuilder->create('Dimimo\Pool\Http\Forms\PoolPlayerForm', [
                'method' => 'PUT',
                'url' => route('pool.player.update', [$player->id]),
                'model' => $player,
            ]);
            $form->add('id', 'hidden', ['value' => $player->id, 'template' => 'vendor.laravel-form-builder.text']);
            $form->add('submit', 'submit', ['label' => 'Update the player '.$player->name, 'attr' => ['class' => 'btn btn-primary']]);
            $forms->push($form);
        }

        return view('pool::players-edit', compact('team', 'new', 'forms'));
    }

    public function updatePlayer(Request $request, int $id): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $player = PoolPlayer::findOrFail($id);
        $request->post('caption', '1');
        $data = $request->all();
        $request->has('captain') ?: $data['captain'] = '0';
        $player->update($data);

        return redirect()->route('pool.players.edit', [$player->team->id])
            ->with(['success' => 'The player <strong>'.$player->name.'</strong> has been updated']);
    }

    /**
     * @throws Exception
     */
    public function deletePlayer(int $id): RedirectResponse
    {
        if (! $this->hasAccess) {
            return redirect()->route('pool.index')
                ->with(['error' => 'You have no access to this page, if you believe this is an error, you should login first']);
        }
        $player = PoolPlayer::findOrFail($id);
        $player->delete();

        return redirect()->route('pool.players.edit', [$player->team->id])
            ->with(['success' => 'The player <strong>'.$player->name.'</strong> has been deleted']);
    }
}
