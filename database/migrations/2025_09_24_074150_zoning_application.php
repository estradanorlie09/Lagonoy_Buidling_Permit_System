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
        Schema::create('zoning_applications', function (Blueprint $table) {
        $table->uuid('id')->primary(); // UUID primary key for application
        $table->uuid('user_id');     // FK to users
        $table->uuid('property_id'); // UUID foreign key
        $table->string('application_no')->unique(); // Business ID (ZN-XXXXXXXX)
        $table->enum('status', ['submitted','approved','disapproved','resubmit','under_review'])->default('submitted');
        $table->timestamps();

        // foreign key constraint
        $table->foreign('property_id')->references('id')->on('zoning_property')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoning_application');
    }
};
