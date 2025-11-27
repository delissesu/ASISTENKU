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
        Schema::table('applications', function (Blueprint $table) {
            $table->dateTime('interview_date')->nullable()->after('status');
            $table->string('interview_location')->nullable()->after('interview_date');
            $table->text('interview_notes')->nullable()->after('interview_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['interview_date', 'interview_location', 'interview_notes']);
        });
    }
};
