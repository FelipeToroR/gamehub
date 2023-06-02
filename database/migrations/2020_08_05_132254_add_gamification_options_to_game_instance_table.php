<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGamificationOptionsToGameInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_instances', function (Blueprint $table) {
            $table->boolean('enable_rewards')->default(0)->after('reward_id');
            $table->boolean('enable_badges')->default(0)->after('enable_rewards');
            $table->boolean('enable_performance_chart')->default(0)->after('enable_badges');
            $table->boolean('enable_leaderboard')->default(1)->after('enable_performance_chart');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_instances', function (Blueprint $table) {
            Schema::drop('enable_rewards');
            Schema::drop('enable_badges');
            Schema::drop('enable_performance_chart');
            Schema::drop('enable_leaderboard');   
        });
    }
}
