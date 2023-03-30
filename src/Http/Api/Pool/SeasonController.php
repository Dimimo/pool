<?php

namespace Dimimo\Pool\http\Api\Pool;

use Dimimo\Pool\Http\Resources\SeasonCollection;
use Dimimo\Pool\Models\PoolDate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SeasonController
 */
class SeasonController extends PoolController
{
    public function getAllSeasons(): SeasonCollection
    {
        return new SeasonCollection($this->getCycles());
    }

    private function getCycles(): Collection
    {
        return PoolDate::select('cycle')->distinct()->orderBy('cycle', 'desc')->get();
    }

    public function changeSeason(Request $request): JsonResponse
    {
        return response()->json(['type' => 'success', 'season' => $request->get('season')]);
    }
}
