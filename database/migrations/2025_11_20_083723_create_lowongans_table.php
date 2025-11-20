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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel division
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            
            // relasi ke tabel users (recruiter yang membuat)
            $table->foreignId('recruiter_id')->constrained('users')->onDelete('cascade');

            $table->string('title');
            $table->text('description');
            $table->integer('quota');

            // ipk dan semester minimum
            $table->decimal('min_ipk', 3, 2);
            $table->integer('min_semester');

            // tanggal buka/tutup
            $table->date('open_date');
            $table->date('close_date');

            // status lowongan
            $table->enum('status', ['draft', 'open', 'closed', 'completed'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
