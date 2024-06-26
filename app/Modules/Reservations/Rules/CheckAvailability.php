<?php

declare(strict_types=1);

namespace App\Modules\Reservations\Rules;

use App\Modules\Locations\Models\Location;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class CheckAvailability implements DataAwareRule, ValidationRule
{
    /**
     * @var array{location_id:int, start_date:string, end_date:string}
     */
    protected array $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($this->data['location_id'])) {
            return;
        }

        $location = Location::find($this->data['location_id']);
        $startDate = Carbon::parse($this->data['start_date']);
        $endDate = Carbon::parse($this->data['end_date']);

        $daysWithSlotsConfiguration = $location->slots()
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->count();

        if ($startDate->diffInDays($endDate, true) >= $daysWithSlotsConfiguration) {
            $message = 'Sorry but we cannot make a reservation for this location, because some days are not configured yet. Please try later!';
            $fail($message);
        }
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
