<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Http\Resources;

use Dimimo\Pool\Models\PoolTeam;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResultCollection extends ResourceCollection
{
    public PoolTeam $team;

    public PoolTeam $played;

    public int      $won;

    public int      $lost;

    public int      $for;

    public int      $against;

    public int      $games_played;

    public string   $last_result;

    public bool     $last_game_won;

    public int      $percentage;

    public int      $rank;

    public int      $max_games;

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
