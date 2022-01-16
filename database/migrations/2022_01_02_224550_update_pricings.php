<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePricings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pricings', function (Blueprint $table) {
            DB::table('pricings')->truncate();
            $table->integer('departure_geoId')->after('departure');
            $table->integer('arrival_geoId')->after('arrival');
            $table->index('departure_geoId');
            $table->index('arrival_geoId');
            $table->unique(['departure_geoId', 'arrival_geoId']);
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
        Schema::table('pricings', function (Blueprint $table) {
            $table->dropForeign(['departure_geoId']);
            $table->dropForeign(['arrival_geoId']);
            $table->dropUnique(['departure_geoId', 'arrival_geoId']);
            $table->dropColumn('departure_geoId');
            $table->dropColumn('arrival_geoId');
        });
        Schema::enableForeignKeyConstraints();
    }
}
