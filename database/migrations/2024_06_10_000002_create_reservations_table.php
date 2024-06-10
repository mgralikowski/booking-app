<?php

use App\Modules\Locations\Models\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', static function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Location::class)
                ->constrained()
                ->cascadeOnUpdate();

            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
