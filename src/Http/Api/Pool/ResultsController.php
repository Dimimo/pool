<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\http\Api\Pool;

use Dimimo\Pool\Http\Controllers\ResultsTrait;
use Dimimo\Pool\Http\Resources\ResultCollection;

/**
 * Class ResultsController
 */
class ResultsController extends PoolController
{
    use ResultsTrait;

    /**
     * Calculate the results and return the collection
     */
    public function results(): ResultCollection
    {
        return new ResultCollection($this->getResults());
    }
}
