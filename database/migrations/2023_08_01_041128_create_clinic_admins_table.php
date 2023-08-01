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
        Schema::create('clinic_admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('email', 30);
            $table->string('phone1', 15);
            $table->string('phone2', 15)->nullable(true);
            $table->integer('clinic_id');
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
        Schema::dropIfExists('clinic_admins');
    }
};
