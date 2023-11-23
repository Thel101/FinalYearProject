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
        Schema::create('service_medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_appointment_id');
            $table->foreign('service_appointment_id')->references('id')->on('service_appointments')->onDelete('cascade');
            $table->integer('patient_id')->unsigned()->nullable();
            $table->string('patient_name');
            $table->integer('booking_person')->unsigned();
            $table->string('result_file');
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
        Schema::dropIfExists('service_medical_records');
    }
};
