<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_no');
            $table->string('email');
            $table->string('phone', 15);
            $table->string('password')->default(Hash::make('P@$$w0rd'));
            $table->integer('specialty_id');
            $table->string('degree', 50);
            $table->longText('experience');
            $table->integer('consultation_fees');
            $table->integer('clinic_id');
            $table->string('photo');
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
        Schema::dropIfExists('doctors');
    }
};
