<?php

use App\Modules\Locations\Http\Controllers\LocationController;
use App\Modules\Locations\Http\Controllers\LocationSlotController;
use App\Modules\Reservations\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'locations' => LocationController::class,
    'slots' => LocationSlotController::class,
    'reservations' => ReservationController::class,
]);