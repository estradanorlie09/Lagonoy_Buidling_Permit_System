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
        Schema::create('building_applications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key for application
            $table->uuid('user_id');     // FK to users
            $table->uuid('property_id'); // UUID foreign key
            $table->string('application_no')->unique(); // Business ID
            $table->string('building_permit_no')->unique()->nullable(); // Business ID
            $table->enum('type_of_application', ['new', 'renewal', 'amendatory'])->default('new');
            $table->enum('status', ['submitted', 'approved', 'disapproved', 'onsite_visitation', 'payment', 'under_review'])->default('submitted');
            $table->uuid('approved_by')->nullable();

            $table->date('issued_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->timestamps();

            // foreign key constraint
            $table->foreign('property_id')->references('id')->on('building_property')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
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
