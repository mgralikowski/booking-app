<?php

use App\Modules\Locations\Models\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location_slots', static function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Location::class)
                ->constrained()
                ->cascadeOnUpdate();

            $table->date('date');
            $table->unsignedSmallInteger('available')->default(0);
            $table->timestamps();

            $table->unique(['location_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('location_slots');
    }
};
