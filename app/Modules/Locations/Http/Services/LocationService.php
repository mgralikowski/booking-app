<?php

declare(strict_types=1);

namespace App\Modules\Locations\Http\Services;

use App\Modules\Locations\Http\Requests\StoreLocationRequest;
use App\Modules\Locations\Http\Requests\StoreSlotRequest;
use App\Modules\Locations\Models\Location;
use App\Modules\Locations\Models\LocationSlot;

class LocationService
{
    public function store(StoreLocationRequest $request): Location
    {
        $location = new Location($request->validated());
        $location->save();

        return $location;
    }

    public function upsertSlot(StoreSlotRequest $request): LocationSlot
    {
        return LocationSlot::updateOrCreate(
            $request->safe()->only(['date', 'location_id']),
            ['available' => $request->validated('available'), 'price' => $request->validated('price')]
        );
    }
}
