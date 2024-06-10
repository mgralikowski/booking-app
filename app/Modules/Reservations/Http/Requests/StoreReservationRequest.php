<?php

namespace App\Modules\Reservations\Http\Requests;

use App\Modules\Locations\Models\Location;
use App\Modules\Reservations\Rules\CheckAvailability;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id' => ['required', new Exists(Location::class, 'id')],
            'start_date' => ['required', 'date', new CheckAvailability()],
            'end_date' => ['required', 'date', 'date:after_or_equal:start_date'],
        ];
    }
}
