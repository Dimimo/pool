<?php

namespace Dimimo\Pool\Database\Factories;

use Dimimo\Pool\Models\PoolPlayer;
use Dimimo\Pool\Models\PoolTeam;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PoolPlayerFactory extends Factory
{
    protected $model = PoolPlayer::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull(),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'captain' => $this->faker->boolean(),
            'contact_nr' => $this->faker->phoneNumber(),
            'cycle' => $this->faker->date('Y/m'),
            'pool_team_id' => PoolTeam::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
