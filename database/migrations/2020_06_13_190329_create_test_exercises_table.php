<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event');
            $table->string('test')->comment('Etiqueta de test que agrupa ejercicios');
            $table->string('label')->comment('Etiqueta identificador de ejercicio');
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
        Schema::dropIfExists('test_exercises');
    }
}
