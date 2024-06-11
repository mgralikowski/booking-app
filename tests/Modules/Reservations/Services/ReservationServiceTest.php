<?php

namespace Tests\Modules\Reservations\Services;

use App\Modules\Locations\Models\Location;
use App\Modules\Locations\Models\LocationSlot;
use App\Modules\Reservations\Data\ReservationRequest;
use App\Modules\Reservations\Services\ReservationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ReservationServiceTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('standardCases')]
    public function testCalculate(string $startDate, string $endDate, float $expectedCost): void
    {
        $location = Location::factory()->create();

        LocationSlot::factory()->create(['location_id' => $location->id, 'date' => '2024-06-10', 'price' => 40]);
        LocationSlot::factory()->create(['location_id' => $location->id, 'date' => '2024-06-11', 'price' => 50]);
        LocationSlot::factory()->create(['location_id' => $location->id, 'date' => '2024-06-12', 'price' => 60]);
        LocationSlot::factory()->create(['location_id' => $location->id, 'date' => '2024-06-13', 'price' => 69.99]);
        LocationSlot::factory()->create(['location_id' => $location->id, 'date' => '2024-06-14', 'price' => 80.01]);

        $reservationRequest = new ReservationRequest(
            $location, Date::parse($startDate), Carbon::parse($endDate),
        );

        // SUT
        $reservationService = new ReservationService();

        $cost = $reservationService->calculate($reservationRequest);

        $this->assertEquals($expectedCost, $cost);
    }

    public static function standardCases(): array
    {
        return [
            'Basic reservation period (3 days)' => [
                '2024-06-10',
                '2024-06-12',
                150,
            ],
            'Basic reservation period (single day)' => [
                '2024-06-11',
                '2024-06-11',
                50,
            ],
            'Basic reservation period (two days, sum of floats)' => [
                '2024-06-12',
                '2024-06-14',
                210,
            ],
        ];
    }
}
