<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->foreign('appointment_id')->references('id')->on('doctor_appointments')->onDelete('cascade');
            $table->text('current_symptoms');
            $table->text('medical_history');
            $table->text('family_history')->nullable(true);
            $table->text('surgery_history')->nullable(true);
            $table->text('prescription');
            $table->text('laboratory_request')->nullable(true);
            $table->text('referral_letter')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_medical_records');
    }
};
