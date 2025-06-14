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
        Schema::table('chats', function (Blueprint $table) {
            // Menambahkan kolom foreign key 'consultation_id'
            // yang terhubung ke tabel 'consultations'
            $table->foreignId('consultation_id')
                  ->nullable() // Kita buat nullable untuk amannya
                  ->after('id') // Posisi kolom (opsional)
                  ->constrained('consultations')
                  ->onDelete('cascade'); // Jika konsultasi dihapus, chatnya juga ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            // Perintah untuk membatalkan migrasi (rollback)
            $table->dropForeign(['consultation_id']);
            $table->dropColumn('consultation_id');
        });
    }
};