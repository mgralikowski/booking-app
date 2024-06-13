<?php

declare(strict_types=1);

namespace App\Modules\Reservations\Http\Controllers;

use App\Modules\Auth\Controllers\Controller;
use App\Modules\Locations\Models\Location;
use App\Modules\Reservations\Data\ReservationRequest;
use App\Modules\Reservations\Http\Requests\StoreReservationRequest;
use App\Modules\Reservations\Models\Reservation;
use App\Modules\Reservations\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ReservationController extends Controller
{
    public function __construct(private readonly ReservationService $reservationService)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Modules/Reservations/Index', [
            'reservations' => Reservation::with('location')->get(),
            'flash' => (bool) session()->get('success'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Modules/Reservations/Form', [
            'locations' => Location::all(),
        ]);
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $this->reservationService->create(ReservationRequest::fromHttpRequest($request));

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully!');
    }
}
