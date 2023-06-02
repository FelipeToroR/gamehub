<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionTypeOriginToGameExercises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_exercises', function (Blueprint $table) {
            $table->string('type')->nullable()->after('round');
            $table->string('memory_origin',3)->nullable()->after('response');
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
            $table->dropColumn('type');
            $table->dropColumn('memory_origin');
        });
    }
}
