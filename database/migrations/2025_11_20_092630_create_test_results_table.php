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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();

            // test_id: foreign key ke tests.id
            // relasinya one to one
            $table->foreignId('test_id')->unique()->constrained('tests')->onDelete('cascade');

            // application_id: foreign key ke applications.id
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');

            // hasil nilai
            $table->decimal('score', 5, 2); // misalnya 100.00 atau 85.50

            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->integer('wrong_answers');

            // lulus atau tidak
            $table->boolean('passed');

            $table->timestamps();

            // memastikan hasil hanya ada satu per pendaftaran
            $table->unique('application_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
