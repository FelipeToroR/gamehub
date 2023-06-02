<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeDatesSurveys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0)->after('description')->comment('Tipo de encuesta');
            $table->dateTime('initial_date')->nullable()->after('type')->comment('Fecha de inicio de despliegue de test');
            $table->dateTime('end_date')->nullable()->after('initial_date')->comment('Fecha de término de despliegue de test');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('initial_date');
            $table->dropColumn('end_date');
        });
    }
}
