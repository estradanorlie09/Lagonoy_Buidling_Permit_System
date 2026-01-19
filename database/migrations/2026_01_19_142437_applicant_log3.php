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
        Schema::create('application_logs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Change from $table->id() to UUID
            $table->uuid('applicant_id');
            $table->uuid('user_id')->nullable();
            $table->string('action');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('applicant_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
