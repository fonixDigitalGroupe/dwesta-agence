<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('point_relais', function (Blueprint $table) {
            if (! Schema::hasColumn('point_relais', 'email')) {
                $table->string('email')->nullable()->after('nom');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('point_relais', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
