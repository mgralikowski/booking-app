<?php

declare(strict_types=1);

namespace App\Modules\Reservations\Http\Resources;

use App\Modules\Reservations\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Reservation */
class ReservationsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'location' => $this->location,
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date->toDateString(),
            'days' => $this->getLength()->d,
            'cost' => $this->cost,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
