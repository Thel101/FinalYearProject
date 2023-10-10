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
        Schema::create('clinics_doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinics_id');
            $table->unsignedBigInteger('doctors_id');
            $table->foreign('clinics_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('doctors_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->string('schedule_day')->nullable(true);
            $table->time('start_time')->nullable(true);
            $table->time('end_time')->nullable(true);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinics_doctors');
    }
};
