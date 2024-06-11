<?php

declare(strict_types=1);

namespace App\Modules\Locations\Http\Controllers;

use App\Modules\Auth\Controllers\Controller;
use App\Modules\Locations\Http\Requests\StoreSlotRequest;
use App\Modules\Locations\Http\Services\LocationService;
use App\Modules\Locations\Models\LocationSlot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class LocationSlotController extends Controller
{
    public function __construct(private readonly LocationService $locationService)
    {
    }

    public function index(): Collection
    {
        return LocationSlot::all(); // @todo use ApiResource
    }

    public function store(StoreSlotRequest $request): LocationSlot
    {
        return $this->locationService->upsertSlot($request); // @todo use ApiResource
    }

    public function show(LocationSlot $locationSlot): LocationSlot
    {
        Gate::authorize('view', $locationSlot);

        return $locationSlot; // @todo use ApiResource
    }
}
