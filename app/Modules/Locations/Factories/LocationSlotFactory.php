<?php

namespace App\Modules\Locations\Factories;

use App\Modules\Locations\Models\Location;
use App\Modules\Locations\Models\LocationSlot;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LocationSlotFactory extends Factory
{
    protected $model = LocationSlot::class;

    public static ?Carbon $currentDate = null;

    public function definition(): array
    {
        self::$currentDate = self::$currentDate ? self::$currentDate->addDay() : today();

        return [
            'location_id' => Location::first(),
            'date' => self::$currentDate->toDateString(), // unique() doesn't play well with dates, @see https://github.com/fzaninotto/Faker/issues/984
            'available' => $this->faker->numberBetween(0, 10),
        ];
    }
}
