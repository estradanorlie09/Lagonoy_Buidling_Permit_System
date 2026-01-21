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
        Schema::create('visitations', function (Blueprint $table) {
            // Use UUID as primary key
            $table->uuid('id')->primary();
            $table->uuid('zoning_application_id')->nullable();
            $table->foreign('zoning_application_id')
                ->references('id')->on('zoning_applications')
                ->onDelete('cascade');

            $table->uuid('sanitary_application_id')->nullable();
            $table->foreign('sanitary_application_id')
                ->references('id')->on('sanitary_applications')
                ->onDelete('cascade');

            $table->uuid('building_application_id')->nullable();
            $table->foreign('building_application_id')
                ->references('id')->on('building_applications')
                ->onDelete('cascade');

            $table->date('visit_date');
            $table->time('visit_time');
            $table->enum('status', ['pending', 'completed', 'cancelled', 'rescheduled', 'scheduled', 'absent'])->default('scheduled');

            $table->text('remarks')->nullable();

            $table->uuid('scheduled_by')->nullable();
            $table->foreign('scheduled_by')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->timestamps();
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
