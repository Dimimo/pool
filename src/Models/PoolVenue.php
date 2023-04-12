<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Models;

use Dimimo\Pool\Database\Factories\PoolVenueFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Dimimo\Pool\Models\PoolVenue
 *
 * @property int                         $id
 * @property string                      $name
 * @property string|null                 $address
 * @property string|null                 $contact_name
 * @property string|null                 $contact_nr
 * @property string|null                 $remark
 * @property string|null                 $lat
 * @property string|null                 $lng
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property-read Collection|PoolEvent[] $events
 * @property-read int|null               $events_count
 * @property-read Collection|PoolTeam[]  $teams
 * @property-read int|null               $teams_count
 *
 * @method static Builder|PoolVenue newModelQuery()
 * @method static Builder|PoolVenue newQuery()
 * @method static Builder|PoolVenue query()
 * @method static Builder|PoolVenue whereAddress($value)
 * @method static Builder|PoolVenue whereContactName($value)
 * @method static Builder|PoolVenue whereContactNr($value)
 * @method static Builder|PoolVenue whereCreatedAt($value)
 * @method static Builder|PoolVenue whereId($value)
 * @method static Builder|PoolVenue whereLat($value)
 * @method static Builder|PoolVenue whereLng($value)
 * @method static Builder|PoolVenue whereName($value)
 * @method static Builder|PoolVenue whereRemark($value)
 * @method static Builder|PoolVenue whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PoolVenue extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pool_venues';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'address' => 'string',
        'contact_name' => 'string',
        'contact_nr' => 'string',
        'lat' => 'decimal',
        'lng' => 'decimal',
        'name' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'address',
        'contact_name',
        'contact_nr',
        'lat',
        'lng',
        'name',
        'remark',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected static function newFactory(): PoolVenueFactory
    {
        return PoolVenueFactory::new();
    }

    /**
     * A venue has many teams
     *
     * @return HasMany<PoolTeam>
     */
    public function teams(): HasMany
    {
        return $this->hasMany(PoolTeam::class, 'pool_venue_id', 'id');
    }

    /**
     * A venue has many events
     *
     * @return HasMany<PoolEvent>
     */
    public function events(): HasMany
    {
        return $this->hasMany(PoolEvent::class, 'pool_venue_id', 'id');
    }
}
