<?php

declare(strict_types=1);

namespace App\Modules\Reservations\Http\Controllers\Api;

use App\Modules\Auth\Controllers\Controller;
use App\Modules\Misc\Responses\ApiResponse;
use App\Modules\Reservations\Data\ReservationRequest;
use App\Modules\Reservations\Http\Requests\StoreReservationRequest;
use App\Modules\Reservations\Http\Resources\ReservationResource;
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
     * @return AnonymousResourceCollection<ReservationResource>
     */
    public function index(): AnonymousResourceCollection
    {
        return ReservationResource::collection(Reservation::all());
    }

    public function calculate(StoreReservationRequest $request): JsonResponse
    {
        return ApiResponse::success([
            'price' => $this->reservationService->calculate(ReservationRequest::fromHttpRequest($request)),
            'currency' => 'EUR', // @todo config
        ]);
    }

    public function store(StoreReservationRequest $request): ReservationResource
    {
        return new ReservationResource($this->reservationService->create(ReservationRequest::fromHttpRequest($request)));
    }

    public function show(Reservation $reservation): ReservationResource
    {
        return new ReservationResource($reservation);
    }

    public function cancel(Reservation $reservation): JsonResponse
    {
        $this->reservationService->cancel($reservation);

        return ApiResponse::success(message: 'Reservation has been cancelled.');
    }
}
