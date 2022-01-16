<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAirports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('airports', function (Blueprint $table) {
            DB::table('airports')->truncate();
            $table->dropForeign(['country_id']);
            $table->dropForeign(['region_id']);
            $table->dropColumn('continent_id');
            $table->renameColumn('country_id', 'iso_country');
            $table->renameColumn('region_id', 'iso_region');
            $table->string('name', 200)->change();
            $table->string('city', 200)->change();
            $table->string('type', 50)->nullable()->after('name');

            $table->integer('geonameid')->default(0)->after('iata');
            $table->integer('geoNameIdCity')->default(0)->after('city');
            $table->index('geonameid');
            $table->index('geoNameIdCity');
            $table->foreign('geoNameIdCity')->references('geonameid')->on('cities')->onDelete('cascade');
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
        Schema::table('airports', function (Blueprint $table) {
            $table->dropForeign(['geoNameIdCity']);
            $table->dropColumn('geoNameIdCity');
            $table->dropColumn('geonameid');
        });
        Schema::table('airports', function (Blueprint $table) {
            $table->string('continent_id', 2)->nullable();
            $table->renameColumn('iso_country', 'country_id');
            $table->renameColumn('iso_region', 'region_id');
            $table->string('name', 191)->change();
            $table->string('city', 191)->change();
            $table->dropColumn('type');
            $table->foreign('country_id')->references('country_id')->on('countries')->onDelete('cascade');
            $table->foreign('region_id')->references('region_id')->on('regions')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }
}
