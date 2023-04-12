<?php
/**
 *  Copyright (c) 2016-2022 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Models;

use Dimimo\Pool\Database\Factories\PoolTeamFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Dimimo\Pool\Models\PoolTeam
 *
 * @property int                          $id
 * @property string                       $name
 * @property int                          $pool_venue_id
 * @property string|null                  $remark
 * @property string                       $cycle
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property-read Collection|PoolPlayer[] $players
 * @property-read int|null                $players_count
 * @property-read Collection|PoolEvent[]  $team_1
 * @property-read int|null                $team_1_count
 * @property-read Collection|PoolEvent[]  $team_2
 * @property-read int|null                $team_2_count
 * @property-read PoolVenue|null          $venue
 *
 * @method static Builder|PoolTeam cycle()
 * @method static Builder|PoolTeam newModelQuery()
 * @method static Builder|PoolTeam newQuery()
 * @method static Builder|PoolTeam query()
 * @method static Builder|PoolTeam whereCreatedAt($value)
 * @method static Builder|PoolTeam whereCycle($value)
 * @method static Builder|PoolTeam whereId($value)
 * @method static Builder|PoolTeam whereName($value)
 * @method static Builder|PoolTeam wherePoolVenueId($value)
 * @method static Builder|PoolTeam whereRemark($value)
 * @method static Builder|PoolTeam whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PoolTeam extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pool_teams';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'cycle' => 'string',
        'name' => 'string',
        'pool_venue_id' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'cycle',
        'name',
        'pool_venue_id',
        'remark',
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
    public function scopeCycle(PoolTeam|Builder $query): Builder
    {
        return $query->where('cycle', session('cycle'));
    }

    /**
     * Calculates the percentages of a given score table of a team
     * The results are to be found in CycleController@
     */
    public function percentage(array $result): float
    {
        return round(((($result['won'] / $result['max_games']) * 100) + (($result['for'] / (($result['max_games']) * 15)) * 100)) / 2);
    }

    /**
     * Return the captain of the team or null if there is no captain assigned
     */
    public function captain(): ?PoolPlayer
    {
        /** @phpstan-ignore-next-line */
        return $this->players()->where('captain', '1')->get()->first();
    }

    protected static function newFactory(): PoolTeamFactory
    {
        return PoolTeamFactory::new();
    }

    /**************************************
     *
     * The eloquent relationships
     *
     **************************************/
    /**
     * A team has many players
     *
     * @return HasMany<PoolPlayer>
     */
    public function players(): HasMany
    {
        return $this->hasMany(PoolPlayer::class);
    }

    /**
     * A team has one venue
     *
     * @return BelongsTo<PoolVenue, PoolTeam>
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(PoolVenue::class, 'pool_venue_id');
    }

    /**
     * A team has many events as team 1
     *
     * @return HasMany<PoolEvent>
     */
    public function team_1(): HasMany
    {
        return $this->hasMany(PoolEvent::class, 'team1');
    }

    /**
     * A team has many events as team 2
     *
     * @return HasMany<PoolEvent>
     */
    public function team_2(): HasMany
    {
        return $this->hasMany(PoolEvent::class, 'team2');
    }
}
