<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Forms;

use Dimimo\Pool\Models\PoolVenue;
use Kris\LaravelFormBuilder\Form;

class PoolTeamForm extends Form
{
    public function buildForm(): void
    {
        $venues = PoolVenue::orderBy('name')->pluck('name', 'id')->toArray();
        $this->add('name', 'text', [
            'label' => 'Name of the Team',
            'help_block' => ['text' => 'fas fa-edit'],
            'rules' => 'required|min:2|max:80',
            'error_messages' => [
                'name.required' => 'Please provide a name',
                'name.min' => 'The name needs to be at least 2 chars long',
                'name.max' => 'Please shorten the name (max 80 chars)',
            ],
        ]);
        $this->add('pool_venue_id', 'select', [
            'label' => 'Venue',
            'empty_value' => ' -- select the venue -- ',
            'choices' => $venues,
            'selected' => function () {
                if (isset($this->model->venue)) {
                    return $this->model->venue->id;
                }

                return null;
            },
            'rules' => 'required',
            'error_messages' => ['pool_venue_id.required' => 'Please chose a venue'],
        ]);
        $this->add('remark', 'textarea', [
            'label' => 'Remark (optional)',
            'rules' => 'max:500',
            'attr' => ['rows' => '2'],
            'error_messages' => ['remark.max' => 'Please shorten your description (max 500 chars)'],
        ]);
        $this->add('cycle', 'text', [
            'label' => 'Game Cycle (can not be changed)',
            'help_block' => ['text' => 'fas fa-tag'],
            'attr' => ['readonly' => 'readonly', 'title' => 'Cycles can not be changed, please copy a team for new cycles'],
            'rules' => 'sometimes|regex:/([\d]{4}\/[\d]{2})/',
            'error_message' => ['regex' => 'Please provide a correct pattern, for example '.date('Y/m')],
        ]);
    }
}
