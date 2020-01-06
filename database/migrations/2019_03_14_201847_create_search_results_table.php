<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('search_id')->unsigned();
            $table->string('result_id');
            $table->string('seller_id');
            $table->string('seller_name');
            $table->string('seller_icao');
            $table->string('lift_id');
            $table->string('aircraft_category');
            $table->string('aircraft_type');
            $table->decimal('price', 11, 4)->unsigned();
            $table->string('currency', 3);
            $table->timestamps();

            // Foreign keys
            $table->foreign('search_id')->references('id')->on('searches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_results');
    }
}
