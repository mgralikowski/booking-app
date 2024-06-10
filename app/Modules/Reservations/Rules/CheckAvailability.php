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
        $location = Location::find($this->data['location_id']);
        $startDate = Carbon::parse($this->data['start_date']);
        $endDate = Carbon::parse($this->data['end_date']);

        $daysWithoutAvailableSlots = $location->slots()
            ->where('available', '<=', 0)->whereBetween('date', [$startDate, $endDate])
            ->get();

        if ($daysWithoutAvailableSlots->isNotEmpty()) {
            $dates = ($daysWithoutAvailableSlots->pluck('date')->transform(static fn (Carbon $carbon): string => $carbon->toDateString()));
            $message = 'Sorry but we cannot make a reservation for this location, because some days ('.$daysWithoutAvailableSlots->count().') are without free slots in the given range. ';
            $message .= 'Unavailable dates: '.$dates->implode(', ').'. Please redefine a start and/or end date.';
            // @reconsider Use lang (trans_choice).

            $fail($message);
        }
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
