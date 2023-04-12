<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Models;

use Dimimo\Pool\Database\Factories\PoolEventFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Dimimo\Pool\Models\PoolEvent
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
 *
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
 *
 * @mixin Eloquent
 */
class PoolEvent extends Model
{
    use HasFactory;

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
        'pool_date_id' => 'integer',
        'pool_venue_id' => 'integer',
        'team1' => 'integer',
        'team2' => 'integer',
        'score1' => 'integer',
        'score2' => 'integer',
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

    protected static function newFactory(): PoolEventFactory
    {
        return PoolEventFactory::new();
    }

    /**
     * An event belongs to a date
     *
     * @return BelongsTo<PoolDate, PoolEvent>
     */
    public function date(): BelongsTo
    {
        return $this->belongsTo(PoolDate::class, 'pool_date_id', 'id');
    }

    /**
     * An event belongs to a venue
     *
     * @return BelongsTo<PoolVenue, PoolEvent>
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(PoolVenue::class, 'pool_venue_id', 'id');
    }

    /**
     * An event belongs to team 1
     *
     * @return BelongsTo<PoolTeam, PoolEvent>
     */
    public function team_1(): BelongsTo
    {
        return $this->belongsTo(PoolTeam::class, 'team1', 'id');
    }

    /**
     * An event belongs to team 2
     *
     * @return BelongsTo<PoolTeam, PoolEvent>
     */
    public function team_2(): BelongsTo
    {
        return $this->belongsTo(PoolTeam::class, 'team2', 'id');
    }
}
