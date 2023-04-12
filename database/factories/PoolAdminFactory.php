<?php

namespace Dimimo\Pool\Database\Factories;

use Dimimo\Pool\Models\PoolAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PoolAdminFactory extends Factory
{
    protected $model = PoolAdmin::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull(),
            'database' => $this->faker->randomElement(['mysql', 'other']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
