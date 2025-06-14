

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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('psychologist_id')->constrained('users');
            $table->foreignId('availability_id')->nullable()->constrained('availabilities'); // Slot waktu yang dipesan
            $table->dateTime('requested_start_time');
            $table->unsignedInteger('duration_minutes');
            $table->unsignedInteger('psychologist_price'); // Harga psikolog saat itu
            $table->unsignedInteger('admin_fee'); // 5% fee
            $table->unsignedInteger('total_payment');
            $table->string('status')->default('pending_payment'); // pending_payment, pending_verification, confirmed, completed, cancelled, expired
            $table->timestamp('expires_at'); // Batas waktu pembayaran (1 jam setelah dibuat)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
