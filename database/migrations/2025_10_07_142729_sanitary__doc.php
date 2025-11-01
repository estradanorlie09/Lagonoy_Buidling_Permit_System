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
        Schema::create('sanitary_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sanitary_application_id');
            $table->uuid('approved_id')->nullable();
            $table->string('document_type');
            $table->string('file_path');
            $table->unsignedInteger('version')->default(1);
            $table->string('status')->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('sanitary_application_id')
                ->references('id')
                ->on('sanitary_applications')
                ->onDelete('cascade');
            $table->foreign('approved_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
