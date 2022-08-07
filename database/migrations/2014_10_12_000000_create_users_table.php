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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('password');
            $table->foreignId('team_id')->nullable();
            $table->unsignedBigInteger('score');
            $table->string('phone_code',5);
            $table->string('phone_number', 20)->unique()->nullable();
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->enum('gender',['male', 'female', 'other'])->nullable();
            $table->string('google_id', 50)->unique()->nullable();
            $table->string('facebook_id', 50)->unique()->nullable();
            $table->string('user_language',5)->nullable();
            $table->enum('photo_source',['site', 'facebook', 'google'])->default('site');
            $table->string('src',100)->nullable();
            $table->tinyInteger('upload_driver')->default(0);
            $table->enum('status',['pending','active', 'inactive','disabled'])->default('pending');
            $table->rememberToken();
            $table->softDeletes();
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
