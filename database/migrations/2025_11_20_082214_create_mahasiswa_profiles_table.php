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
        Schema::create('mahasiswa_profiles', function (Blueprint $table) {
            $table->id();
            // user_id : foreign key ke tabel users
            // constraint cascade, user dihapus, profil mahasiswa juga ikut kehapus
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // data akademik mahasiswa
            $table->string('nim', 12)->unique();
            $table->string('program_studi', 50);
            $table->year('angkatan');
            $table->decimal('ipk', 3, 2);
            $table->integer('semester')->default(1);

            // file upload
            $table->string('foto', 255)->nullable();
            $table->string('cv_path', 255)->nullable();
            $table->string('transkrip_path', 255)->nullable();

            $table->timestamps();

            // up index perform
            $table->index('nim'); // Sudah unique, tapi explicit index
            $table->index('angkatan'); // Sering filter by angkatan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_profiles');
    }
};
