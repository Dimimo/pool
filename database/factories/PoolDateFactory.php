<?php

namespace Dimimo\Pool\Database\Factories;

use Dimimo\Pool\Models\PoolDate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PoolDateFactory extends Factory
{
    protected $model = PoolDate::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'cycle' => $this->faker->date('Y/m'),
            'date' => $this->faker->date(),
            'regular' => $this->faker->boolean(),
            'remark' => $this->faker->words(3, true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
