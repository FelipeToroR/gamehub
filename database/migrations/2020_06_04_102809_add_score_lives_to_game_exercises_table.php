<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreLivesToGameExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_exercises', function (Blueprint $table) {
            $table->bigInteger('score')->nullable()->after('response');
            $table->integer('lives')->nullable()->after('score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_exercises', function (Blueprint $table) {
            $table->dropColumn('score');
            $table->dropColumn('lives');
        });
    }
}
