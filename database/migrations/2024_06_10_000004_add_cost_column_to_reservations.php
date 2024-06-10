<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', static function (Blueprint $table) {
            $table->decimal('cost')->unsigned()->after('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', static function (Blueprint $table) {
            $table->dropColumn('cost');
        });
    }
};
