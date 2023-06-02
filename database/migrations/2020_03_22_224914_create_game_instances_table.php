<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameInstancesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_instances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('game_id')->unsigned()->default(0);
            $table->integer('experiment_id')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('experiment_id')->references('id')->on('experiments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_instances');
    }
}
