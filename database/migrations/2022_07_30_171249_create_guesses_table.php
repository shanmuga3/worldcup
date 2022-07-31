<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('match_id');
            $table->unsignedInteger('first_team_score');
            $table->unsignedInteger('second_team_score');
            $table->unsignedInteger('first_team_penalty')->nullable();
            $table->unsignedInteger('second_team_penalty')->nullable();
            $table->unsignedTinyInteger('round');
            $table->unsignedBigInteger('score')->nullable();
            $table->boolean('answer')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('match_id')->references('id')->on('matches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guesses');
    }
}
