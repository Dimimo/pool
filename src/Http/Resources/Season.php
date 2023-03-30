<?php

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Models\PoolDate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Season
 */
class Season extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        /** @var $this PoolDate */
        return [
            'season' => $this->cycle,
        ];
    }
}
