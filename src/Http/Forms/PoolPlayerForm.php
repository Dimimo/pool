<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Forms;

use Dimimo\Pool\Models\PoolTeam;
use Kris\LaravelFormBuilder\Form;

class PoolPlayerForm extends Form
{
    /**
     * @return void
     */
    public function buildForm(): void
    {
        $team = PoolTeam::cycle()->orderBy('name')->pluck('name', 'id')->toArray();
        $this->add('name', 'text', [
            'label'          => 'Name of the player',
            'help_block'     => ['text' => 'fas fa-edit'],
            'rules'          => 'required|min:2|max:80',
            'error_messages' => [
                'name.required' => 'Please provide a name',
                'name.min'      => 'The name needs to be at least 2 chars long',
                'name.max'      => 'Please shorten the name (max 80 chars)',
            ],
        ]);
        $this->add('contact_nr', 'text', [
            'label'      => 'Telephone number',
            'help_block' => ['text' => 'fas fa-mobile-alt'],
        ]);
        $this->add('pool_team_id', 'select', [
            'label'          => 'Team',
            'empty_value'    => ' -- select the team -- ',
            'choices'        => $team,
            'selected'       => function ()
            {
                if (isset($this->model->team))
                {
                    return $this->model->team->id;
                }

                return null;
            },
            'rules'          => 'required',
            'error_messages' => ['required' => 'Please add this player to a team'],
        ]);
        $this->add('captain', 'checkbox', [
            'wrapper'    => ['class' => 'custom-control custom-switch pb-1'],
            'attr'       => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label pl-2', 'style' => 'color: #7ba065;'],
        ]);
        $this->add('cycle', 'text', [
            'label'          => 'Game Cycle (can not be changed)',
            'help_block'     => ['text' => 'fas fa-tag'],
            'attr'           => ['readonly' => 'readonly', 'title' => 'Cycles can not be changed, please copy a team for new cycles'],
            'rules'          => 'sometimes|regex:/([\d]{4}\/[\d]{2})/',
            'error_messages' => ['regex' => 'Please provide a correct pattern, for example ' . date('Y/m')],
        ]);
    }
}
