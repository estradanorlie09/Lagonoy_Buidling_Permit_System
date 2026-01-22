<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('application_id');
            $table->string('document_key');
            $table->boolean('is_submitted')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->uuid('submitted_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('application_id')->references('id')->on('building_applications')->onDelete('cascade');
            $table->foreign('submitted_by')->references('id')->on('users')->onDelete('set null');

            // Unique constraint
            $table->unique(['application_id', 'document_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_checklists');
    }
};
