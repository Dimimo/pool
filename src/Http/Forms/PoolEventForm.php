<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Forms;

use Carbon\Carbon;
use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Models\PoolTeam;
use Dimimo\Pool\Models\PoolVenue;
use Kris\LaravelFormBuilder\Form;

/**
 * Class PoolEventForm
 */
class PoolEventForm extends Form
{
    public function buildForm(): void
    {
        $dates = PoolDate::cycle()->orderBy('date', 'desc')->get()->pluck('date', 'id')->map(function (Carbon $date) {
            return $date->format('Y-m-d');
        })->toArray();
        //collect the relevant ids of venues for this season
        $venue_ids = PoolTeam::cycle()->orderBy('name')->get()->unique('pool_venue_id')->pluck('pool_venue_id')->toArray();
        //only show the venues that are relevant for this season
        $venues = PoolVenue::orderBy('name')->whereIn('id', $venue_ids)->where('name', '<>', 'BYE')->get()->pluck('name', 'id')->toArray();
        $teams = PoolTeam::cycle()->orderBy('name')->get()->pluck('name', 'id')->toArray();
        $this->add('pool_date_id', 'select', [
            'label' => 'Playing date',
            'empty_value' => ' -- select a date -- ',
            'choices' => $dates,
            'selected' => function () {
                if (isset($this->model->pool_date_id)) {
                    $date = PoolDate::find($this->model->pool_date_id);

                    return $date->id;
                } else {
                    return null;
                }
            },
            'rules' => 'required',
            'error_messages' => ['pool_date_id.required' => 'Please chose a playing date'],
        ]);
        $this->add('team1', 'select', [
            'label' => 'Home Team',
            'empty_value' => ' -- select the Home Team -- ',
            'choices' => $teams,
            'selected' => function () {
                return $this->model->team1 ?? null;
            },
            'rules' => 'required',
            'error_messages' => ['team1.required' => 'Please chose the Home Team'],
        ]);
        $this->add('team2', 'select', [
            'label' => 'Visiting Team',
            'empty_value' => ' -- select the Visiting Team -- ',
            'choices' => $teams,
            'selected' => function () {
                return $this->model->team2 ?? null;
            },
            'rules' => 'required',
            'error_messages' => ['team2.required' => 'Please chose the Visiting Team'],
        ]);
        $this->add('pool_venue_id', 'select', [
            'label' => 'Venue (auto-filled when Home Team is selected)',
            'empty_value' => ' -- select a Venue -- ',
            'choices' => $venues,
            'selected' => function () {
                return $this->model->pool_venue_id ?? null;
            },
            'rules' => 'required',
            'error_messages' => ['pool_venue_id.required' => 'Please choose a venue'],
        ]);
        $this->add('score1', 'text', [
            'label' => 'The score of Team 1 (optional, can be added later)',
            'help_block' => ['text' => 'fas fa-edit'],
            'rules' => 'nullable|numeric|gt:-1|lt:16',
            'error_messages' => [
                'score1.min' => 'The value is not numeric',
                'score1.gt' => 'The value has to be 0 or bigger',
                'score1.lt' => 'The value has to be 15 or less',
            ],
        ]);
        $this->add('score2', 'text', [
            'label' => 'The score of Team 2 (optional, can be added later)',
            'help_block' => ['text' => 'fas fa-edit'],
            'rules' => 'nullable|numeric|gt:-1|lt:16',
            'error_messages' => [
                'score2.numeric' => 'The value is not numeric',
                'score2.gt' => 'The value has to be 0 or bigger',
                'score2.lt' => 'The value has to be 15 or less',
            ],
        ]);
        $this->add('remark', 'textarea', [
            'label' => 'Remark (optional)',
            'attr' => ['rows' => 2],
            'rules' => 'max:500',
            'error_messages' => ['remark.max' => 'Please shorten your description (max 500 chars)'],
        ]);
    }
}
