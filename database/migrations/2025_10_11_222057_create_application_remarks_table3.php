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
        Schema::create('application_remark', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('zoning_application_id')->nullable();
            $table->uuid('sanitary_application_id')->nullable();
            $table->uuid('building_application_id')->nullable();
            $table->uuid('officer_id');

            $table->text('remark');
            $table->timestamps();

            // Foreign keys
            $table->foreign('zoning_application_id')
                ->references('id')->on('zoning_applications')
                ->onDelete('cascade');

            $table->foreign('sanitary_application_id')
                ->references('id')->on('sanitary_applications')
                ->onDelete('cascade');

            $table->foreign('building_application_id')
                ->references('id')->on('building_applications')
                ->onDelete('cascade');

            $table->foreign('officer_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_remarks');
    }
};
