<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Di dalam file ...create_psychologist_profiles_table.php

    public function up(): void
    {
        Schema::create('psychologist_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ktp_number')->comment('Nomor KTP');
            $table->string('university');
            $table->year('graduation_year');
            $table->string('certificate_path')->comment('Path ke file ijazah/sertifikat');
            $table->string('ktp_path')->comment('Path ke file KTP');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psychologist_profiles');
    }
};