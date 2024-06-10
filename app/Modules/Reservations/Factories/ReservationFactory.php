<?php

namespace App\Modules\Reservations\Factories;

use App\Modules\Reservations\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        return [
            'location_id' => 1,
            'start_date' => today(),
            'end_date' => today()->addDays($this->faker->numberBetween(1, 7)),
        ];
    }
}
