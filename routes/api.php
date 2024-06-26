<?php

use App\Modules\Locations\Http\Controllers\LocationController;
use App\Modules\Locations\Http\Controllers\LocationSlotController;
use App\Modules\Reservations\Http\Controllers\Api\ReservationController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'locations' => LocationController::class,
    'slots' => LocationSlotController::class,
    'reservations' => ReservationController::class,
]);
Route::post('reservations/calculate', [ReservationController::class, 'calculate'])->name('reservations.calculate');
Route::put('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
