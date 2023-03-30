<?php

namespace Dimimo\Pool\Http\Controllers\Api\Pool;

use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Http\Resources\SeasonCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SeasonController
 *
 * @package Dimimo\Pool\Http\Controllers\Api\Pool
 */
class SeasonController extends PoolController
{
    /**
     * @return SeasonCollection
     */
    public function getAllSeasons(): SeasonCollection
    {
        return new SeasonCollection($this->getCycles());
    }

    /**
     * @return Collection
     */
    private function getCycles(): Collection
    {
        return PoolDate::select('cycle')->distinct()->orderBy('cycle', 'desc')->get();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function changeSeason(Request $request): JsonResponse
    {
        return response()->json(['type' => 'success', 'season' => $request->get('season')]);
    }
}
