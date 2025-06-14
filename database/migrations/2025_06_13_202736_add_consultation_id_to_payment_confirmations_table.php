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
        Schema::table('payment_confirmations', function (Blueprint $table) {
            $table->foreignId('consultation_id')->after('id')->constrained('consultations')->onDelete('cascade');
            // Pastikan kolom lain seperti `payment_proof`, `amount`, `status` ('pending', 'verified', 'rejected') ada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_confirmations', function (Blueprint $table) {
            //
        });
    }
};
