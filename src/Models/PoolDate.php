<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\PoolDate
 *
 * @property int                         $id
 * @property Carbon                      $date
 * @property bool                        $regular
 * @property string|null                 $title
 * @property string                      $cycle
 * @property string|null                 $remark
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property-read Collection|PoolEvent[] $events
 * @property-read int|null               $events_count
 *
 * @method static Builder|PoolDate cycle()
 * @method static Builder|PoolDate newModelQuery()
 * @method static Builder|PoolDate newQuery()
 * @method static Builder|PoolDate query()
 * @method static Builder|PoolDate whereCreatedAt($value)
 * @method static Builder|PoolDate whereCycle($value)
 * @method static Builder|PoolDate whereDate($value)
 * @method static Builder|PoolDate whereId($value)
 * @method static Builder|PoolDate whereRegular($value)
 * @method static Builder|PoolDate whereRemark($value)
 * @method static Builder|PoolDate whereTitle($value)
 * @method static Builder|PoolDate whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PoolDate extends Model
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
    protected $table = 'pool_dates';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'regular' => 'boolean',
        'title' => 'string',
        'cycle' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'date',
        'regular',
        'title',
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
    public function scopeCycle(PoolDate|\Illuminate\Contracts\Database\Eloquent\Builder $query): PoolDate|\Illuminate\Contracts\Database\Eloquent\Builder
    {
        return $query->where('cycle', session('cycle'));
    }

    /**
     * Check if a guest has write access to a pool day overview, this access is only valid from 12pm to 17pm
     */
    public function checkIfGuestHasWritableAccess(): bool
    {
        $now = Carbon::now();
        $begin = $this->date->format('Y-m-d 12:00:00');
        $end = $this->date->format('Y-m-d 20:00:00');

        return $now->between($begin, $end);
    }

    /**
     * A date has many events
     *
     * @return HasMany<PoolEvent>
     */
    public function events(): HasMany
    {
        return $this->hasMany(PoolEvent::class);
    }
}
