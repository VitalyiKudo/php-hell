<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('searches', function (Blueprint $table) {
            $table->integer('departure_geoId')->default(0)->after('start_airport_name');
            $table->integer('arrival_geoId')->default(0)->after('end_airport_name');
            $table->index('departure_geoId');
            $table->index('arrival_geoId');
            $table->foreign('departure_geoId')->references('geonameid')->on('cities')->onDelete('cascade');
            $table->foreign('arrival_geoId')->references('geonameid')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('searches', function (Blueprint $table) {
            $table->dropForeign(['departure_geoId']);
            $table->dropForeign(['arrival_geoId']);
            $table->dropColumn('departure_geoId');
            $table->dropColumn('arrival_geoId');
        });
        Schema::enableForeignKeyConstraints();
    }
}
