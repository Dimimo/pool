<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class PoolVenueForm extends Form
{
    /**
     * @return void
     */
    public function buildForm(): void
    {
        $this->add('name', 'text', [
            'label'          => 'Name of the Venue',
            'help_block'     => ['text' => 'fas fa-edit'],
            'rules'          => 'required|min:2|max:20',
            'error_messages' => [
                'name.required' => 'Please provide a name',
                'name.min'      => 'The name needs to be at least 2 chars long',
                'name.max'      => 'Please shorten the name (max 20 chars)',
            ],
        ]);
        $this->add('address', 'text', [
            'label'      => 'Address',
            'help_block' => ['text' => 'fas fa-home'],
        ]);
        $this->add('contact_name', 'text', [
            'label'      => 'Contact name',
            'help_block' => ['text' => 'fas fa-user-circle'],
        ]);
        $this->add('contact_nr', 'text', [
            'label'      => 'Telephone number',
            'help_block' => ['text' => 'fas fa-mobile-alt'],
        ]);
        $this->add('remark', 'textarea', [
            'label'          => 'Remark (optional)',
            'attr'           => ['rows' => 2],
            'rules'          => 'max:500',
            'error_messages' => ['Please shorten your description (max 500 chars)'],
        ]);
        $this->add('lat', 'text', [
            'label'          => 'Latitude (ignore, this is for Google Maps)',
            'help_block'     => ['text' => 'fas fa-map-marker'],
            'rules'          => 'sometimes|max:13',
            'error_messages' => [
                'lat.max' => 'Enter no more than 13 characters',
            ],
        ]);
        $this->add('lng', 'text', [
            'label'          => 'Longitude',
            'help_block'     => ['text' => 'fas fa-map-marker'],
            'rules'          => 'sometimes|max:13',
            'error_messages' => [
                'lng.max' => 'Enter no more than 13 characters',
            ],
        ]);
    }
}
