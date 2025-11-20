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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();

            // application_id: foreign key ke applications.id
            // relasinya one to one karena satu aplikasi hanya punya satu sesi tes
            $table->foreignId('application_id')->unique()->constrained('applications')->onDelete('cascade');

            // waktu dan durasi
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('duration_minutes');

            // status ujian
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'expired'])->default('not_started');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
