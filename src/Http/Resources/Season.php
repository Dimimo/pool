<?php

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Models\PoolDate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Season
 *
 * @package App\Http\Resources\Pool
 */
class Season extends JsonResource
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
        /** @var $this PoolDate */
        return [
            'season' => $this->cycle,
        ];
    }
}
