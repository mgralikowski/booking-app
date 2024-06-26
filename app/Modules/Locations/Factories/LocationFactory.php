<?php

namespace App\Modules\Locations\Factories;

use App\Modules\Locations\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['The Plaza', 'Hotel Ritz', 'Taj Mahal Palace', 'Belmond Copacabana Palace']),
            'address' => $this->faker->address(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
