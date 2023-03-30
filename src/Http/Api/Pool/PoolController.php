<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\http\Api\Pool;

use Dimimo\Pool\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class PoolController
 */
class PoolController extends Controller
{
    protected ?string $season;

    /**
     * PoolController constructor.
     */
    public function __construct(Request $request)
    {
        $this->season = $request->header('season');
        session()->put('cycle', $this->season); //for compatibility with traits
        parent::__construct();
    }
}
