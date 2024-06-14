<?php

namespace App\Modules\Reservations\Filament\Resources\ReservationResource\Pages;

use App\Modules\Reservations\Filament\Resources\ReservationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;
}
