<?php

declare(strict_types=1);

namespace App\Modules\Reservations\Data;

use App\Modules\Locations\Models\Location;
use App\Modules\Reservations\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Carbon;

readonly class ReservationRequest
{
    public function __construct(
        public Location $location,
        public Carbon $startDate,
        public Carbon $endDate)
    {
    }

    public static function fromHttpRequest(StoreReservationRequest $reservationRequest): self
    {
        return new self(
            Location::find($reservationRequest->location_id),
            $reservationRequest->date('start_date'),
            $reservationRequest->date('end_date')
        );
    }
}
