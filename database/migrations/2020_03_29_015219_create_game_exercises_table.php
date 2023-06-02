<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameExercisesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event');
            $table->integer('round')->nullable();
            $table->text('exercise')->nullable();
            $table->text('user_response')->nullable();
            $table->text('response')->nullable();
            $table->timestamp('time_start')->nullable();
            $table->timestamp('time_end')->nullable();
            $table->json('extra')->nullable();
            $table->integer('game_instance_id')->unsigned()->default(0);
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('game_instance_id')->references('id')->on('game_instances');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_exercises');
    }
}
