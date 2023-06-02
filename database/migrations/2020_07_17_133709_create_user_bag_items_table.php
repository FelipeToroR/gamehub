<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBagItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bag_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->integer('game_instance_id')->unsigned()->default(0);
            $table->integer('bag_item_type_id')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('game_instance_id')->references('id')->on('game_instances');
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
        Schema::drop('user_bag_items');
    }
}
