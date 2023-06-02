<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExperienceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_experience_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('amount')->default(0);
            $table->bigInteger('user_experience_id')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('user_experience_id')->references('id')->on('user_experiences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_experience_transactions');
    }
}
