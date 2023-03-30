<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Http\Resources\Team as TeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Result extends JsonResource
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
        /** @var $this ResultCollection */
        return [
            'team'          => new TeamResource($this->team),
            'played'        => new TeamResource($this->played),
            'won'           => $this->won,
            'lost'          => $this->lost,
            'for'           => $this->for,
            'against'       => $this->against,
            'games_played'  => $this->games_played,
            'last_result'   => $this->last_result,
            'last_game_won' => $this->last_game_won,
            'percentage'    => $this->percentage,
            'rank'          => $this->rank,
            'max_games'     => $this->max_games,
        ];
    }
}
