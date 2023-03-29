<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Belongsto;
use Illuminate\Support\Carbon;

/**
 * App\Models\PoolEvent
 *
 * @property int                 $id
 * @property int                 $pool_date_id
 * @property int                 $pool_venue_id
 * @property int                 $team1
 * @property int                 $team2
 * @property int|null            $score1
 * @property int|null            $score2
 * @property string|null         $remark
 * @property Carbon|null         $created_at
 * @property Carbon|null         $updated_at
 * @property-read PoolDate|null  $date
 * @property-read PoolTeam|null  $team_1
 * @property-read PoolTeam|null  $team_2
 * @property-read PoolVenue|null $venue
 * @method static Builder|PoolEvent newModelQuery()
 * @method static Builder|PoolEvent newQuery()
 * @method static Builder|PoolEvent query()
 * @method static Builder|PoolEvent whereCreatedAt($value)
 * @method static Builder|PoolEvent whereId($value)
 * @method static Builder|PoolEvent wherePoolDateId($value)
 * @method static Builder|PoolEvent wherePoolVenueId($value)
 * @method static Builder|PoolEvent whereRemark($value)
 * @method static Builder|PoolEvent whereScore1($value)
 * @method static Builder|PoolEvent whereScore2($value)
 * @method static Builder|PoolEvent whereTeam1($value)
 * @method static Builder|PoolEvent whereTeam2($value)
 * @method static Builder|PoolEvent whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PoolEvent extends Model
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
    protected $table = 'pool_events';
    /**
     * @var array<string, string>
     */
    protected $casts = [
        'pool_date_id'  => 'integer',
        'pool_venue_id' => 'integer',
        'team1'         => 'integer',
        'team2'         => 'integer',
        'score1'        => 'integer',
        'score2'        => 'integer',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'pool_date_id',
        'pool_venue_id',
        'team1',
        'team2',
        'score1',
        'score2',
        'remark',
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['team_1', 'team_2'];

    /**
     * An event belongs to a date
     *
     * @return Belongsto<PoolDate, PoolEvent>
     */
    public function date(): Belongsto
    {
        return $this->belongsTo(PoolDate::class, 'pool_date_id', 'id');
    }

    /**
     * An event belongs to a venue
     *
     * @return Belongsto<PoolVenue, PoolEvent>
     */
    public function venue(): Belongsto
    {
        return $this->belongsTo(PoolVenue::class, 'pool_venue_id', 'id');
    }

    /**
     * An event belongs to team 1
     *
     * @return Belongsto<PoolTeam, PoolEvent>
     */
    public function team_1(): Belongsto
    {
        return $this->belongsTo(PoolTeam::class, 'team1', 'id');
    }

    /**
     * An event belongs to team 2
     *
     * @return Belongsto<PoolTeam, PoolEvent>
     */
    public function team_2(): Belongsto
    {
        return $this->belongsTo(PoolTeam::class, 'team2', 'id');
    }
}
