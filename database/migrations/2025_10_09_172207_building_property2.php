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
        Schema::create('building_property', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key
            $table->enum('occupancy_type', [
                'residential',
                'commercial',
                'industrial',
                'institutional',
                'agricultural',
                'recreational',
                'mixed_use',
                'others',
            ]);
            $table->string('project_title');
            $table->integer('number_of_floor');
            $table->decimal('floor_area', 10, 2);
            $table->decimal('lot_area', 10, 2);
            $table->decimal('estimated_cost', 15, 2);
            $table->string('property_address');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('comments')->nullable();
            $table->timestamps(); // created_at and updated_at
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
