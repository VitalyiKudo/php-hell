<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirportAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airport_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icao', 12)->nullable(false);
            $table->integer('geoNameIdCity')->default(0);
            $table->smallInteger('sortBy')->default(0);
            $table->index('icao');
            $table->index('geoNameIdCity');
            $table->index('sortBy');
            $table->unique(['icao', 'geoNameIdCity']);
            $table->timestamps();
            $table->foreign('icao')->references('icao')->on('airports')->onDelete('cascade');
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
        Schema::dropIfExists('airport_areas');
    }
}
