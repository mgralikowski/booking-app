<?php

namespace Database\Seeders;

use App\Modules\Locations\Models\Location;
use App\Modules\Locations\Models\LocationSlot;
use App\Modules\Reservations\Models\Reservation;
use App\Modules\Users\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Location::factory(2)->create();
        LocationSlot::factory(15)->create();
        Reservation::factory()->create();
    }
}
