<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperatorCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operator_cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 255)->nullable()->index();
            $table->integer('geoNameIdCity')->default(0)->index();
            $table->unique(['email', 'geoNameIdCity']);
            $table->timestamps();
            $table->foreign('email')->references('email')->on('operators')->onDelete('cascade');
            $table->foreign('geoNameIdCity')->references('geonameid')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operator_cities');
    }
}
