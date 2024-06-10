<?php

declare(strict_types=1);

namespace App\Modules\Locations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Locations\Http\Requests\StoreSlotRequest;
use App\Modules\Locations\Models\LocationSlot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class LocationSlotController extends Controller
{
    public function index(): Collection
    {
        return LocationSlot::all(); // @todo use ApiResource
    }

    public function store(StoreSlotRequest $request): LocationSlot
    {
        // @todo use Action or Repository/Service
        return LocationSlot::updateOrCreate(
            $request->safe()->only(['date', 'location_id']),
            ['available' => $request->validated('available'), 'price' => $request->validated('price')]
        );
        // @todo use ApiResource
    }

    public function show(LocationSlot $locationSlot): LocationSlot
    {
        Gate::authorize('view', $locationSlot);

        return $locationSlot; // @todo use ApiResource
    }
}
