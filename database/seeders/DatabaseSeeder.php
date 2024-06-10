<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Modules\Locations\Models\Location;
use App\Modules\Locations\Models\LocationSlot;
use App\Modules\Reservations\Models\Reservation;
use Illuminate\Database\Seeder;

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
