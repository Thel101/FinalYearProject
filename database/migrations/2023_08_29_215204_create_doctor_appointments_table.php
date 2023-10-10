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
        Schema::create('doctor_appointments', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('doctor_id');
            $table->mediumInteger('clinic_id');
            $table->date('appointment_date');
            $table->time('time_slot');
            $table->float('doctor_fees');
            $table->float('clinic_charges');
            $table->float('total_fees');
            $table->string('symptoms');
            $table->mediumInteger('patient_id')->nullable(true)->default(0);
            $table->mediumInteger('booking_person');
            $table->string('patient_name',50);
            $table->string('phone_1',20);
            $table->string('phone_2',20)->nullable(true);
            $table->smallInteger('patient_age');
            $table->string('allergy')->nullable(true);
            $table->string('disease')->nullable(true);
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
        Schema::dropIfExists('doctor_appointments');
    }
};
