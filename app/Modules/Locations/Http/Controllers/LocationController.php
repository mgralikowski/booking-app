<?php

declare(strict_types=1);

namespace App\Modules\Locations\Http\Controllers;

use App\Modules\Auth\Controllers\Controller;
use App\Modules\Locations\Http\Requests\StoreLocationRequest;
use App\Modules\Locations\Http\Services\LocationService;
use App\Modules\Locations\Models\Location;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class LocationController extends Controller
{
    public function __construct(private readonly LocationService $locationService)
    {
    }

    public function index(): Collection
    {
        return Location::all(); // @todo use ApiResource
    }

    public function store(StoreLocationRequest $request): Location
    {
        return $this->locationService->store($request);
    }

    public function show(Location $location): Location
    {
        Gate::authorize('view', $location);

        return $location; // @todo use ApiResource
    }
}
