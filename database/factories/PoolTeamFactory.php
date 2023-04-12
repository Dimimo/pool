<?php

namespace Dimimo\Pool\Database\Factories;

use Dimimo\Pool\Models\PoolTeam;
use Dimimo\Pool\Models\PoolVenue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PoolTeamFactory extends Factory
{
    protected $model = PoolTeam::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'remark' => $this->faker->words(3, true),
            'cycle' => $this->faker->date('Y/m'),
            'pool_venue_id' => PoolVenue::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
