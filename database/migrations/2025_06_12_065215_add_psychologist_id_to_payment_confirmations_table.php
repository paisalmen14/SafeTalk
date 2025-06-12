<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_xx_xx_xxxxxx_add_psychologist_id_to_payment_confirmations_table.php
public function up(): void
{
    Schema::table('payment_confirmations', function (Blueprint $table) {
        $table->foreignId('psychologist_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('payment_confirmations', function (Blueprint $table) {
        $table->dropForeign(['psychologist_id']);
        $table->dropColumn('psychologist_id');
    });
}
};
