<?php

namespace App\Modules\Reservations\Http\Requests;

use App\Modules\Locations\Models\Location;
use App\Modules\Reservations\Rules\CheckAvailability;
use App\Modules\Reservations\Rules\CheckVacancies;
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
            'start_date' => ['bail', 'required', 'date', 'before_or_equal:end_date', new CheckAvailability(), new CheckVacancies()],
            'end_date' => ['bail', 'required', 'date', 'after_or_equal:start_date'],
        ];
    }
}
