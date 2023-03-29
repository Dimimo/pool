<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Forms;

use Dimimo\Pool\Models\PoolVenue;
use Kris\LaravelFormBuilder\Form;

class PoolTeamShortForm extends Form
{
    public function buildForm(): void
    {
        $venues = PoolVenue::where('name', '<>', 'BYE')->orderBy('name')->pluck('name', 'id')->toArray();
        $this->add('name', 'text', [
            'label' => 'Name of the Team',
            'help_block' => ['text' => 'fas fa-edit'],
            'rules' => 'required|min:2|max:20',
            'error_messages' => [
                'name.required' => 'Please provide a name',
                'name.min' => 'The name needs to be at least 2 chars long',
                'name.max' => 'Please shorten the name (max 20 chars)',
            ],
        ]);
        $this->add('pool_venue_id', 'select', [
            'label' => 'Venue',
            'empty_value' => ' -- select the venue -- ',
            'choices' => $venues,
            'selected' => null,
            'rules' => 'required',
            'error_messages' => ['pool_venue_id.required' => 'Please choose a venue'],
        ]);
    }
}
