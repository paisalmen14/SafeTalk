<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_add_chosen_psychologist_id_to_users_table.php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('chosen_psychologist_id')->nullable()->after('psychologist_status')->constrained('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['chosen_psychologist_id']);
        $table->dropColumn('chosen_psychologist_id');
    });
}
};
