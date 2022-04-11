<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmptyLegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empty_legs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icao_departure', 12)->nullable(false)->index();
            $table->string('icao_arrival', 12)->nullable(false)->index();
            $table->integer('geoNameIdCity_departure')->index();
            $table->integer('geoNameIdCity_arrival')->index();
            $table->string('type_plane', 20)->nullable(false)->index();
            $table->string('operator', 255)->index();
            $table->decimal('price', 10, 2);
            $table->timestamp('date_departure');
            $table->boolean('active')->index()->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('icao_departure')->references('icao')->on('airports')->onDelete('cascade');
            $table->foreign('icao_arrival')->references('icao')->on('airports')->onDelete('cascade');
            $table->foreign('geoNameIdCity_departure')->references('geonameid')->on('cities')->onDelete('cascade');
            $table->foreign('geoNameIdCity_arrival')->references('geonameid')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empty_legs');
    }
}
