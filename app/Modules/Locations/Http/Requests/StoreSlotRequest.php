<?php

declare(strict_types=1);

namespace App\Modules\Locations\Http\Requests;

use App\Modules\Locations\Models\Location;
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
            'location_id' => ['required', new Exists(Location::class, 'id')],
            'date' => ['required', 'date'],
            'available' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
