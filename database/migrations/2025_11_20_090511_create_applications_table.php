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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // lowongan_id: foreign key ke lowongans.id
            $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');

            // mahasiswa_id: foreign key ke users.id
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');

            // kolom tambahan, sifatnya opsional sih buat medkre misalnya
            $table->string('portofolio_url')->nullable(); 
            $table->text('motivation_letter')->nullable();
            $table->text('admin_notes')->nullable(); 

            // status pendaftaran
            $table->enum('status', ['pending', 'verified', 'test', 'interview', 'accepted', 'rejected'])->default('pending');
            
            // waktu pendaftaran
            $table->timestamp('applied_at')->useCurrent();

            $table->timestamps();

            // satu mahasiswa hanya satu lowongan
            $table->unique(['lowongan_id', 'mahasiswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
