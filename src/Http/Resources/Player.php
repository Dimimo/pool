<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Models\PoolPlayer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Player extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        /** @var $this PoolPlayer */
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'phone'   => $this->contact_nr,
            'captain' => (bool) $this->captain,
        ];
    }
}
