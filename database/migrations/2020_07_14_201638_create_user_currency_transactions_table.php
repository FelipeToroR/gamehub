<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCurrencyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_currency_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('amount')->default(0);
            $table->set('operation', ['DEBIT', 'CREDIT']);  // DEBIT => Agrega, CREDIT => Resta	
            $table->bigInteger('user_currency_id')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('user_currency_id')->references('id')->on('user_currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_currency_transactions');
    }
}
