<?php

namespace Dimimo\Pool\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class SeasonCollection
 */
class SeasonCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
