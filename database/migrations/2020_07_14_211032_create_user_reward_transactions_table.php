<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRewardTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reward_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('game_instance_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            #########$table->bigInteger('reward_item_id')->unsigned();
            $table->integer('day_counter');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('game_instance_id')->references('id')->on('game_instances');
            $table->foreign('user_id')->references('id')->on('users');
            ############$table->foreign('reward_item_id')->references('id')->on('reward_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_reward_transactions');
    }
}
