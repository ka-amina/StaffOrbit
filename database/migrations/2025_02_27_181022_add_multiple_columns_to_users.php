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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date');
            $table->text('address')->nullable();
            $table->date('recruitment_date');
            $table->foreignId('contract_type')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('departement_id')->unique()->constrained()->onDelete('cascade');
            $table->decimal('salary', 10, 2);
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
