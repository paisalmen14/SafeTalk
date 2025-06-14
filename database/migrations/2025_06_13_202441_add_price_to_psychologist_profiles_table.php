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
        Schema::table('psychologist_profiles', function (Blueprint $table) {
        $table->unsignedInteger('price_per_hour')->default(100000);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psychologist_profiles', function (Blueprint $table) {
            //
        });
    }
};
