<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardDayItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_day_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->integer('reward_day_id')->unsigned()->default(0);
            $table->integer('bag_item_type_id')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('reward_day_id')->references('id')->on('reward_days');
            $table->foreign('bag_item_type_id')->references('id')->on('bag_item_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reward_day_items');
    }
}
