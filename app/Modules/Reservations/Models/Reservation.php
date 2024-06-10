<?php

declare(strict_types=1);

namespace App\Modules\Reservations\Models;

use App\Modules\Locations\Models\Location;
use App\Modules\Misc\Models\ModuleHasFactory;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use ModuleHasFactory;

    protected $fillable = ['start_date', 'end_date', 'cost'];

    protected $casts = ['start_date' => 'date:Y-m-d', 'end_date' => 'date:Y-m-d', 'cost' => 'double'];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function getLength(): CarbonInterval
    {
        return $this->end_date->diff($this->start_date);
    }

    public function getPeriod(): CarbonPeriod
    {
        return CarbonPeriod::create($this->start_date, $this->end_date);
    }
}
