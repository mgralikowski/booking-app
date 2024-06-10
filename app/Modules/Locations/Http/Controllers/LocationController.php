<?php

declare(strict_types=1);

namespace App\Modules\Locations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Locations\Http\Requests\StoreLocationRequest;
use App\Modules\Locations\Models\Location;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class LocationController extends Controller
{
    public function index(): Collection
    {
        return Location::all(); // @todo use ApiResource
    }

    public function store(StoreLocationRequest $request): Location
    {
        // @todo use Action or Service
        $location = new Location($request->validated());
        $location->save();

        return $location; // @todo use ApiResource
    }

    public function show(Location $location): Location
    {
        Gate::authorize('view', $location);

        return $location; // @todo use ApiResource
    }
}
