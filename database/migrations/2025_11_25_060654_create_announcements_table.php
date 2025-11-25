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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            
            $table->string('title');
            $table->text('content');
            
            // jenis pengumuman: info, warning, success, hasil, jadwal, wawancara
            $table->enum('type', ['info', 'warning', 'success', 'hasil', 'jadwal', 'wawancara'])->default('info');
            
            // target audience: all, students, recruiters
            $table->enum('target_audience', ['all', 'students', 'recruiters'])->default('all');
            
            // status aktif
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
