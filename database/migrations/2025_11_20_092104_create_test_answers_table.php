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
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();

            // test_id: foreign key ke tests.id
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade');

            // question_id: foreign key ke question_banks.id
            $table->foreignId('question_id')->constrained('question_banks')->onDelete('cascade');

            // jawaban mahasiwa
            $table->enum('answer', ['a', 'b', 'c', 'd'])->nullable();

            // status koreksi
            $table->boolean('is_correct')->nullable(); // dihitung setelah ujian selesai

            $table->timestamps();
            
            // satu soal hanya bisa dijawab sekali
            $table->unique(['test_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_answers');
    }
};
