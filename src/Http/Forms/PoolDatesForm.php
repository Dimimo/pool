<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class PoolDatesForm extends Form
{
    public function buildForm(): void
    {
        $count = $this->model->events()->count();
        //some hidden fields
        $this->add('id['.$this->model->id.']', 'hidden', ['value' => $this->model->id, 'template' => 'vendor.laravel-form-builder.text']);
        $this->add('cycle['.$this->model->id.']', 'hidden', ['value' => $this->model->cycle, 'template' => 'vendor.laravel-form-builder.text']);
        //start the building of the visible form model
        $this->add('date['.$this->model->id.']', 'date', [
            'label' => '('.trans_choice('plural.games', $count, ['value' => $count]).')',
            'label_attr' => ['class' => 'control-label mr-1 mb-3'],
            'help_block' => ['text' => 'fas fa-calendar'],
            'rules' => 'unique:pool_dates,date|date_format:Y-m-d',
            'value' => $this->model->date->format('Y-m-d'),
            'attr' => [
                'data-provide' => 'datepicker',
                'data-date-format' => 'yyyy-mm-dd',
                'data-date-today-highlight' => 'true',
                'data-date-autoclose' => 'true',
                'data-date-today-btn' => 'linked',
                'data-date-week-start' => '1',
                'title' => 'Check if this is a non-regular Playing Date and specify the title',
                'size' => 10,
                'maxlength' => 10,
            ],
            'error_messages' => [
                'date.unique' => 'This date already exists',
                'date.format' => 'Something is ',
            ],
        ]);
        $this->add('regular['.$this->model->id.']', 'checkbox', [
            'label' => 'Special?',
            'wrapper' => ['class' => 'form-group has-success mx-2 mb-3'],
            'attr' => ['class' => 'mr-1'],
            'value' => 1,
            'checked' => $this->model->regular,
        ]);
        $this->add('title['.$this->model->id.']', 'text', [
            'label' => ' ',
            'help_block' => ['text' => 'fas fa-edit'],
            'rules' => 'nullable|sometimes|max:80',
            'error_messages' => [
                //'title.min' => 'The title needs to be at least 2 chars long',
                'title.max' => 'Please shorten the title (max 80 chars)',
            ],
            'attr' => [
                'placeholder' => 'Regular playing day',
                'size' => 20,
                'maxlength' => 80,
            ],
            'value' => function () {
                if (isset($this->model->title)) {
                    return $this->model->title;
                }

                return null;
            },
        ]);
        //add the submit button
        $this->add('submit['.$this->model->id.']', 'submit', [
            'label' => 'Update',
            'attr' => ['class' => 'btn btn-primary btn-sm ml-1 mb-3'],
        ]);
        //check for empty events in a date, add a delete button
        if ($this->model->events()->count() === 0) {
            $this->add('delete['.$this->model->id.']', 'checkbox', [
                'wrapper' => ['class' => 'form-group mb-2'],
                'label' => 'Confirm delete',
                'attr' => ['class' => 'mx-2'],
            ]);
            $this->add('delete', 'submit', [
                'label' => 'Delete',
                'attr' => ['class' => 'btn btn-danger btn-sm ml-1 mb-3'],
            ]);
        }
    }
}
