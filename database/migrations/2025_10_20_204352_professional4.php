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
        Schema::create('professionals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('building_application_id');
            $table->string('prof_type');
            $table->string('prof_name');
            $table->string('prc_no');
            $table->string('ptr_no');
            $table->string('phone_number');
            $table->string('email');
            $table->date('birthday');
            $table->string('prof_address');

            $table->foreign('building_application_id')
                ->references('id')
                ->on('building_applications')
                ->onDelete('cascade');
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
