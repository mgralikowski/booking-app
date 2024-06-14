<?php

declare(strict_types=1);

namespace App\Modules\Locations\Models;

use App\Modules\Misc\Models\ModuleHasFactory;
use App\Modules\Reservations\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use ModuleHasFactory;

    protected $fillable = ['name', 'address'];

    public function slots(): HasMany
    {
        return $this->hasMany(LocationSlot::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
