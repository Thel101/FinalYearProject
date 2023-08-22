<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone1', 20);
            $table->string('phone2', 15)->nullable(true);
            $table->string('address', 200)->nullable(true);
            $table->string('role')->default('user');
            $table->integer('status')->default(1);
            $table->integer('clinic_id')->nullable(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(Hash::make('P@$$w0rd'));
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
