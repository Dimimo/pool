<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Models\PoolVenue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Venue extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        /** @var $this PoolVenue */
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'address' => $this->address,
            'owner'   => $this->contact_name,
            'phone'   => $this->contact_nr,
            'remark'  => $this->remark,
        ];
    }
}
