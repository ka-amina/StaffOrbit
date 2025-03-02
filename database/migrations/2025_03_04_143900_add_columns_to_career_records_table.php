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
        Schema::table('career_records', function (Blueprint $table) {
            $table->decimal('salary', 10, 2)->nullable()->after('user_id');
            $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('set null');
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('set null');
            $table->foreignId('grade_id')->nullable()->constrained('grades')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_records', function (Blueprint $table) {
            
            $table->dropForeign(['salary_id']);
            $table->dropForeign(['formation_id']);
            $table->dropForeign(['contract_id']);
            $table->dropForeign(['grade_id']);

            $table->dropColumn(['salary_id', 'formation_id', 'contract_id', 'grade_id']);
        });
    }
};