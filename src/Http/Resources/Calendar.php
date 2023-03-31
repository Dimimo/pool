<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Http\Resources\Event as EventResource;
use Dimimo\Pool\Models\PoolDate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PoolDate */
class Calendar extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('jS \o\f M Y'),
            'regular' => $this->regular,
            'title' => $this->title,
            'remark' => $this->remark,
            'events' => $this->when($this->events, EventResource::collection($this->events)),
        ];
    }
}
