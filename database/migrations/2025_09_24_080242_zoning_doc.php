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
        Schema::create('zoning_documents', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->uuid('zoning_application_id');

            $table->string('document_type'); 
            $table->string('file_path');     
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();

            $table->foreign('zoning_application_id')
                  ->references('id')
                  ->on('zoning_applications')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('zoning_document');
    }
};
