<?php

namespace App\Modules\Locations\Models;

use App\Modules\Misc\Models\ModuleHasFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class LocationSlot extends Model
{
    use ModuleHasFactory;

    protected $fillable = ['location_id', 'date', 'available'];

    protected $casts = ['date' => 'date:Y-m-d'];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Format date in errors.
     *
     * @param  Carbon  $date
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->toDateString();
    }
}
