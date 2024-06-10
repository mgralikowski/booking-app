<?php

namespace App\Modules\Locations\Http\Requests;

use App\Modules\Locations\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class StoreSlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id' => ['required', new Exists(Reservation::class, 'id')],
            'date' => ['required', 'date'],
            'available' => ['required', 'numeric', 'min:0'],
        ];
    }
}
