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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key\
            $table->enum('profession', [
                'architect',
                'civil_engineer',
                'electrical_engineer',
                'sanitary_engineer',
                'master_plumber',
                'geodetic_engineer',
                'mechanical_engineer',
            ])->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('email')->unique();
            $table->string('password'); // Store hashed password
            $table->string('phone')->nullable();
            $table->string('province')->nullable();
            $table->string('municipality')->nullable();
            $table->string('barangay')->nullable();
            $table->string('street')->nullable();
            $table->enum('role', ['applicant', 'admin', 'obo', 'zoning_officer', 'sanitary_officer', 'do', 'bfp', 'professional'])->default('applicant');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps(); // created_at and updated_at
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
