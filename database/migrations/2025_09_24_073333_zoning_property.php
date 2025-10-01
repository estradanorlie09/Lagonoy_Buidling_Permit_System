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
         Schema::create('zoning_property', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key
            $table->string('property_address');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->decimal('lot_area', 10, 2);
            $table->string('tax_declaration');
            $table->string('comments')->nullable();
            $table->enum('ownership_type', ['owner','authorized_representative'])->default('owner');
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
