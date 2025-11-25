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
        // Add score columns to tests table
        Schema::table('tests', function (Blueprint $table) {
            $table->decimal('score', 5, 2)->nullable()->after('status');
            $table->boolean('passed')->default(false)->after('score');
        });
        
        // Drop test_results table (redundant)
        Schema::dropIfExists('test_results');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate test_results table
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('test_id')->unique()->constrained('tests')->onDelete('cascade');
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            
            $table->decimal('score', 5, 2);
            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->integer('wrong_answers');
            $table->boolean('passed');
            
            $table->timestamps();
            
            $table->unique('application_id');
        });
        
        // Remove columns from tests table
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn(['score', 'passed']);
        });
    }
};
