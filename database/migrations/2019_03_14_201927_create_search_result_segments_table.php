<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchResultSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_result_segments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('search_result_id')->unsigned();
            $table->string('start_airport_id');
            $table->string('start_airport_name');
            $table->string('start_airport_city');
            $table->string('start_airport_country_code');
            $table->string('start_airport_country_name');
            $table->string('start_airport_icao');
            $table->string('start_airport_iata');
            $table->string('end_airport_id');
            $table->string('end_airport_name');
            $table->string('end_airport_city');
            $table->string('end_airport_country_code');
            $table->string('end_airport_country_name');
            $table->string('end_airport_icao');
            $table->string('end_airport_iata');
            $table->integer('block_minutes')->unsigned();
            $table->integer('flight_minutes')->unsigned();
            $table->integer('fuel_minutes')->unsigned();
            $table->integer('distance_nm')->unsigned();
            $table->timestamp('departure_at')->nullable();
            $table->timestamp('arrival_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('search_result_id')->references('id')->on('search_results')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_result_segments');
    }
}
