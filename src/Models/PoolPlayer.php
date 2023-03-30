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
use Illuminate\Database\Eloquent\Relations\Belongsto;
use Illuminate\Support\Carbon;

/**
 * Dimimo\Pool\Models\PoolPlayer
 *
 * @property int                $id
 * @property int|null           $user_id
 * @property string             $name
 * @property string|null        $gender
 * @property int                $pool_team_id
 * @property bool               $captain
 * @property string|null        $contact_nr
 * @property string             $cycle
 * @property Carbon|null        $created_at
 * @property Carbon|null        $updated_at
 * @property-read PoolTeam|null $team
 * @property-read User|null     $user
 *
 * @method static Builder|PoolPlayer cycle()
 * @method static Builder|PoolPlayer newModelQuery()
 * @method static Builder|PoolPlayer newQuery()
 * @method static Builder|PoolPlayer query()
 * @method static Builder|PoolPlayer whereCaptain($value)
 * @method static Builder|PoolPlayer whereContactNr($value)
 * @method static Builder|PoolPlayer whereCreatedAt($value)
 * @method static Builder|PoolPlayer whereCycle($value)
 * @method static Builder|PoolPlayer whereGender($value)
 * @method static Builder|PoolPlayer whereId($value)
 * @method static Builder|PoolPlayer whereName($value)
 * @method static Builder|PoolPlayer wherePoolTeamId($value)
 * @method static Builder|PoolPlayer whereUpdatedAt($value)
 * @method static Builder|PoolPlayer whereUserId($value)
 *
 * @mixin Eloquent
 */
class PoolPlayer extends Model
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
    protected $table = 'pool_players';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'name' => 'string',
        'pool_team_id' => 'integer',
        'captain' => 'boolean',
        'contact_nr' => 'string',
        'cycle' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'pool_team_id',
        'captain',
        'contact_nr',
        'cycle',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Add the scope ->cycle($cycle)
     */
    public function scopeCycle(Builder|PoolPlayer $query): Builder
    {
        return $query->where('cycle', session('cycle'));
    }

    /**
     * A player belongs to a team (!make sure to filter on cycle!)
     *
     * @return Belongsto<PoolTeam, PoolPlayer>
     */
    public function team(): Belongsto
    {
        return $this->belongsTo(PoolTeam::class, 'pool_team_id', 'id');
    }

    /**
     * A player belongs to a user (only needed if captain and life scores are introduced)
     *
     * @return Belongsto<User, PoolPlayer>
     */
    public function user(): Belongsto
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
