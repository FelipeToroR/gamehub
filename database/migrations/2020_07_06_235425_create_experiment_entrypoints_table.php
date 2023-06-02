<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperimentEntrypointsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiment_entrypoints', function (Blueprint $table) {
            $table->string('token', 30)->primary();
            $table->string('title',  100)->nullable();
            $table->string('information')->nullable();
            $table->integer('obfuscated')->default(0);
            $table->string('default_college')->nullable();
            $table->string('default_course')->nullable();
            $table->integer('experiment_id')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('experiment_entrypoints');
    }
}
