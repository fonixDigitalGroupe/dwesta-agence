<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('point_relais', function (Blueprint $table) {
            if (! Schema::hasColumn('point_relais', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('google_maps_url');
            }
            if (! Schema::hasColumn('point_relais', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('point_relais', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
