<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('first_team_id');
            $table->foreignId('second_team_id');
            $table->unsignedTinyInteger('round');
            $table->string('match_time');
            $table->unsignedInteger('first_team_score');
            $table->unsignedInteger('second_team_score');
            $table->unsignedInteger('first_team_penalty')->nullable();
            $table->unsignedInteger('second_team_penalty')->nullable();
            $table->timestamp('starting_at')->nullable();
            $table->timestamp('ending_at')->nullable();
            $table->boolean('answer')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('first_team_id')->references('id')->on('teams');
            $table->foreign('second_team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
