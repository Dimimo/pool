<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Http\Resources\Venue as VenueResource;
use Dimimo\Pool\Models\PoolTeam;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        /** @var $this PoolTeam */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'venue' => $this->when($this->venue, new VenueResource($this->venue)),
            'players' => $this->when($this->players, new PlayerCollection($this->players)),
            'remark' => $this->remark,
        ];
    }
}
