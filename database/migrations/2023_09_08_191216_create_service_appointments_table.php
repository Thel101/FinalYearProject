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
        Schema::create('service_appointments', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('service_id');
            $table->mediumInteger('clinic_id');
            $table->integer('fees');
            $table->mediumInteger('discount');
            $table->float('total_fees');
            $table->date('appointment_date');
            $table->string('time_slot');
            $table->string('referral_letter');
            $table->integer('patient_id')->nullable(true)->default(0);
            $table->integer('booking_person');
            $table->string('patient_name',50);
            $table->string('phone_1',20);
            $table->string('phone_2',20)->nullable(true);
            $table->smallInteger('patient_age');
            $table->string('allergy')->nullable(true);
            $table->string('disease')->nullable(true);
            $table->integer('token_number');
            $table->enum('status', ['booked','recorded','missed', 'cancelled'])->default('booked');
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
        Schema::dropIfExists('service_appointments');
    }
};
