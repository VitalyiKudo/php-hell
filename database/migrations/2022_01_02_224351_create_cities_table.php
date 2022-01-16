<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('cities', function (Blueprint $table) {
            $table->integer('geonameid')->default('0')->unique();
            $table->string('name',200)->nullable()->index();
            $table->string('asciiname',200)->nullable()->index();
            $table->longText('alternatenames')->nullable();
            $table->string('iso_region',10)->nullable();
            $table->string('iso_countryOld',3)->nullable();
            $table->string('iso_country',3)->nullable();
            $table->decimal('latitude',11,8)->nullable();
            $table->decimal('longitude',11,8)->nullable();
            $table->string('timezone',40)->nullable();
            $table->timestamps();

            $table->foreign('iso_country')->references('country_id')->on('countries')->onDelete('cascade');
            $table->foreign(['iso_region', 'iso_country'])->references(['region_id', 'country_id'])->on('regions')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('cities');
        Schema::enableForeignKeyConstraints();
    }
}
