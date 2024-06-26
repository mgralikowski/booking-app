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
        // @note - reducing queries by using a mass update

        return $reservation;
    }

    public function calculate(ReservationRequest $reservationRequest): float
    {
        return (float) $reservationRequest->location->slots()
            ->whereBetween('date', [$reservationRequest->startDate->toDateString(), $reservationRequest->endDate->toDateString()])
            ->sum('price');
    }

    /**
     * Cancel the reservation (for now - we just release vacancies and delete a reservation)
     */
    public function cancel(Reservation $reservation): void
    {
        $reservation->getPeriod()->forEach(
            static fn (Carbon $day) => LocationSlot::whereBelongsTo($reservation->location)->where('date', $day)->increment('available')
        );
        $reservation->delete();
        // @note - soft-deleting/status.
    }
}
