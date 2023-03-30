<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Dimimo\Pool\Models\PoolScore
 *
 * @method static Builder|PoolScore newModelQuery()
 * @method static Builder|PoolScore newQuery()
 * @method static Builder|PoolScore query()
 *
 * @mixin Eloquent
 */
class PoolScore extends Model
{
    /**
     * The connection to the database
     *
     * @var string|null
     */
    protected $connection = 'mysql';
}
