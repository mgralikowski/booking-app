<?php

declare(strict_types=1);

namespace App\Modules\Reservations\Services;

use App\Modules\Locations\Models\LocationSlot;
use App\Modules\Reservations\Data\ReservationRequest;
use App\Modules\Reservations\Models\Reservation;
use Illuminate\Support\Carbon;

class ReservationService
{
    /**
     * Store reservation records and reduce the number of vacancies in the specific location.
     */
    public function create(ReservationRequest $reservationRequest): Reservation
    {
        $reservation = new Reservation([
            'start_date' => $reservationRequest->startDate,
            'end_date' => $reservationRequest->endDate,
            'cost' => $this->calculate($reservationRequest),
        ]);
        $reservation->location()->associate($reservationRequest->location);
        $reservation->save();

        $reservation->getPeriod()->forEach(
            static fn (Carbon $day) => LocationSlot::whereBelongsTo($reservationRequest->location)->where('date', $day)->decrement('available')
        );
        // @reconsider - reducing queries by using a mass update

        return $reservation;
    }

    public function calculate(ReservationRequest $reservationRequest): float
    {
        return (float) $reservationRequest->location->slots()
            ->whereBetween('date', [$reservationRequest->startDate, $reservationRequest->endDate])
            ->sum('price');
    }
}
