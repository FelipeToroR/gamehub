<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveDescriptionGameInstanceParametersToGameParameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_instance_parameters', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::table('game_parameters', function (Blueprint $table) {
            $table->text('description')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_instance_parameters', function (Blueprint $table) {
            $table->text('description')->nullable();
        });

        Schema::table('game_parameters', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
