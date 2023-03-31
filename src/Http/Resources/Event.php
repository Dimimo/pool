<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Http\Resources\Date as DateResource;
use Dimimo\Pool\Http\Resources\Team as TeamResource;
use Dimimo\Pool\Http\Resources\Venue as VenueResource;
use Dimimo\Pool\Models\PoolEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PoolEvent */
class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array|callable|null
    {
        return [
            'id' => $this->id,
            'score1' => $this->score1,
            'score2' => $this->score2,
            'date' => new DateResource($this->date),
            'venue' => new VenueResource($this->venue),
            'team_1' => new TeamResource($this->team_1),
            'team_2' => new TeamResource($this->team_2),
        ];
    }
}
