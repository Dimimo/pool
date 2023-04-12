<?php

namespace Dimimo\Pool\Database\Factories;

use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Models\PoolEvent;
use Dimimo\Pool\Models\PoolTeam;
use Dimimo\Pool\Models\PoolVenue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PoolEventFactory extends Factory
{
    protected $model = PoolEvent::class;

    public function definition(): array
    {
        return [
            'score1' => $this->faker->randomDigitNotNull(),
            'score2' => $this->faker->randomDigitNotNull(),
            'pool_date_id' => PoolDate::factory(),
            'pool_venue_id' => PoolVenue::factory(),
            'team1' => PoolTeam::factory(),
            'team2' => PoolTeam::factory(),
            'remark' => $this->faker->words(3, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
