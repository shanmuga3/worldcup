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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->from(10001)->startingValue(10001);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('team_id')->nullable();
            $table->unsignedBigInteger('score');
            $table->string('phone_code',5);
            $table->string('phone_number', 20)->unique()->nullable();
            $table->date('dob')->nullable();
            $table->string('city');
            $table->enum('gender',['male', 'female', 'other'])->nullable();
            $table->string('google_id', 50)->unique()->nullable();
            $table->string('facebook_id', 50)->unique()->nullable();
            $table->string('apple_id', 100)->unique()->nullable();
            $table->string('user_language',5)->nullable();
            $table->string('user_currency',5)->nullable();
            $table->enum('photo_source',['site', 'facebook', 'google'])->default('site');
            $table->string('src',100)->nullable();
            $table->tinyInteger('upload_driver')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
