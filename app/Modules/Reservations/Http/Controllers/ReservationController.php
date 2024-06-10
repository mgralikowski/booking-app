<?php

declare(strict_types=1);

namespace App\Modules\Reservations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reservations\Data\ReservationRequest;
use App\Modules\Reservations\Http\Requests\StoreReservationRequest;
use App\Modules\Reservations\Http\Resources\ReservationsResource;
use App\Modules\Reservations\Models\Reservation;
use App\Modules\Reservations\Services\ReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    public function __construct(private readonly ReservationService $reservationService)
    {
    }

    /**
     * @return AnonymousResourceCollection<ReservationsResource>
     */
    public function index(): AnonymousResourceCollection
    {
        return ReservationsResource::collection(Reservation::all());
    }

    public function calculate(StoreReservationRequest $request): JsonResponse
    {
        return response()->json(['data' => [
            'price' => $this->reservationService->calculate(ReservationRequest::fromHttpRequest($request)),
            'currency' => 'EUR', // @todo from config
        ]]);
    }

    public function store(StoreReservationRequest $request): ReservationsResource
    {
        return new ReservationsResource($this->reservationService->create(ReservationRequest::fromHttpRequest($request)));
    }

    public function show(Reservation $reservation): ReservationsResource
    {
        return new ReservationsResource($reservation);
    }
}
