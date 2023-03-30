<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Models;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Dimimo\Pool\Models\PoolAdmin
 *
 * @property int            $id
 * @property int|null       $user_id
 * @property string         $database
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read User|null $user
 *
 * @method static Builder|PoolAdmin newModelQuery()
 * @method static Builder|PoolAdmin newQuery()
 * @method static Builder|PoolAdmin query()
 * @method static Builder|PoolAdmin whereDatabase($value)
 * @method static Builder|PoolAdmin whereId($value)
 * @method static Builder|PoolAdmin whereUpdatedAt($value)
 * @method static Builder|PoolAdmin whereUserId($value)
 *
 * @mixin Eloquent
 */
class PoolAdmin extends Model
{
    /**
     * The connection to the database
     *
     * @var string|null
     */
    protected $connection = 'mysql';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pool_admins';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'database' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'database',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * An admin belongs to a user
     *
     * @return BelongsTo<User, PoolAdmin>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
