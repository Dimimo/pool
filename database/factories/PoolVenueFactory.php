<?php

namespace Dimimo\Pool\Database\Factories;

use Dimimo\Pool\Models\PoolVenue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PoolVenueFactory extends Factory
{
    protected $model = PoolVenue::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'contact_name' => $this->faker->name(),
            'contact_nr' => $this->faker->phoneNumber(),
            'remark' => $this->faker->words(3, true),
            'lat' => $this->faker->latitude(),
            'lng' => $this->faker->longitude(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
