<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Forms;

use Dimimo\Pool\Models\PoolDate;
use Kris\LaravelFormBuilder\Form;

class PoolDateForm extends Form
{
    /**
     * @return void
     */
    public function buildForm(): void
    {
        $cycles = PoolDate::orderBy('cycle', 'desc')->get()->pluck('cycle', 'cycle')->toArray();
        $this->add('date', 'date', [
            'help_block'     => ['text' => 'fas fa-calendar'],
            'rules'          => 'unique:pool_dates,date|date_format:Y-m-d',
            'default_value'  => date('Y-m-d'),
            'attr'           => [
                'data-provide'              => 'datepicker',
                'data-date-format'          => 'yyyy-mm-dd',
                'data-date-today-highlight' => 'true',
                'data-date-autoclose'       => 'true',
                'data-date-today-btn'       => 'linked',
                'data-date-week-start'      => '1',
            ],
            'error_messages' => ['date.unique' => 'This date already exists', 'date.format' => 'Something is '],
        ]);
        $this->add('regular', 'checkbox', [
            'label'         => 'If it\'s a spacial playing day (semi, final, party), activate the switch and specify a title',
            'value'         => '1',
            'default_value' => isset($this->model->regular) && $this->model->regular ? '1' : '0',
            'wrapper'       => ['class' => 'custom-control custom-switch pb-3'],
            'attr'          => ['class' => 'custom-control-input'],
            'label_attr'    => ['class' => 'custom-control-label pl-2', 'style' => 'color: #7ba065;'],
        ]);
        $this->add('title', 'text', [
            'label'          => 'Specify a title if non-regular',
            'help_block'     => ['text' => 'fas fa-edit'],
            'rules'          => 'nullable|min:2|max:80',
            'error_messages' => [
                'title.min' => 'The title needs to be at least 2 chars long',
                'title.max' => 'Please shorten the title (max 80 chars)',
            ],
            'attr'           => ['placeholder' => 'Regular playing day'],
        ]);
        $this->add('cycle', 'select', [
            'label'    => 'Select the season',
            'choices'  => $cycles,
            'selected' => function ()
            {
                if (isset($this->model->cycle))
                {
                    return $this->model->cycle;
                }

                return session('cycle');
            },
        ]);
        $this->add('new_cycle', 'text', [
            'label'          => 'Create a new season (!)',
            'help_block'     => ['text' => 'fas fa-recycle red'],
            'rules'          => 'nullable|regex:/[\d]{4}\/[\d]{2}/',
            'error_messages' => ['new_cycle.regex' => 'Please enter the format ' . date('Y/m')],
        ]);
    }
}
