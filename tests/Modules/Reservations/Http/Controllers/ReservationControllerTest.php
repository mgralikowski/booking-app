<?php

declare(strict_types=1);

namespace Tests\Modules\Reservations\Http\Controllers;

use App\Modules\Locations\Models\Location;
use App\Modules\Locations\Models\LocationSlot;
use App\Modules\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore(): void
    {
        $this->actingAs(User::factory()->create());

        $location = $this->standardLocationAndSlots();

        $response = $this->postJson(route('api.reservations.store'), ['start_date' => '2024-06-10', 'end_date' => '2024-06-12', 'location_id' => $location->getKey()]);
        $response->assertStatus(201);
        $response->assertJsonPath('data.id', 1);
        $response->assertJsonPath('data.cost', 150);

        $this->assertDatabaseHas('reservations', ['id' => 1, 'cost' => 150]);
    }

    public function testCalculate(): void
    {
        $expectedPrice = 90;
        $location = $this->standardLocationAndSlots();

        $response = $this->postJson(route('api.reservations.calculate'), ['start_date' => '2024-06-10', 'end_date' => '2024-06-11', 'location_id' => $location->getKey()]);
        $response->assertStatus(200);
        $response->assertJson(['data' => ['price' => $expectedPrice, 'currency' => 'EUR']]);
    }

    public function testCalculateOnRangeWhenSlotConfigurationIsMissing(): void
    {
        $location = Location::factory()->create();
        LocationSlot::factory()->create(['location_id' => $location->getKey(), 'date' => '2024-06-10', 'price' => 40]);
        // MISSING
        LocationSlot::factory()->create(['location_id' => $location->getKey(), 'date' => '2024-06-12', 'price' => 50]);

        $response = $this->postJson(route('api.reservations.calculate'), ['start_date' => '2024-06-10', 'end_date' => '2024-06-12', 'location_id' => $location->getKey()]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('start_date');
    }

    public function testCalculateWhenLocationIsUnavailable(): void
    {
        $location = $this->standardLocationAndSlots();
        $response = $this->postJson(route('api.reservations.calculate'), ['start_date' => '2024-05-13', 'end_date' => '2024-05-14', 'location_id' => $location->getKey()]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('start_date');
    }

    public function testCalculateOnInvalidRange(): void
    {
        $location = $this->standardLocationAndSlots();
        $response = $this->postJson(route('api.reservations.calculate'), ['start_date' => '2024-05-10', 'end_date' => '2024-02-09', 'location_id' => $location->getKey()]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('start_date');
    }

    public function testCalculateWhenLocationIsMissing(): void
    {
        $response = $this->postJson(route('api.reservations.calculate'), ['start_date' => '2024-05-10', 'end_date' => '2024-02-09']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('location_id');
    }

    private function standardLocationAndSlots(): Location
    {
        $location = Location::factory()->create();
        LocationSlot::factory()->available()->create(['location_id' => $location->getKey(), 'date' => '2024-06-10', 'price' => 40]);
        LocationSlot::factory()->available()->create(['location_id' => $location->getKey(), 'date' => '2024-06-11', 'price' => 50]);
        LocationSlot::factory()->available()->create(['location_id' => $location->getKey(), 'date' => '2024-06-12', 'price' => 60]);
        LocationSlot::factory()->available()->create(['location_id' => $location->getKey(), 'date' => '2024-06-13', 'price' => 70]);
        LocationSlot::factory()->create(['location_id' => $location->getKey(), 'date' => '2024-06-14', 'price' => 80, 'available' => 0]);

        return $location;
    }
}
