<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAirportsTable extends Migration
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
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
            $table->dropColumn('area');
            $table->dropColumn('source_id');
        });
        Schema::table('airports', function (Blueprint $table) {
            $table->string('country_id', 3)->after('city');
            $table->string('region_id', 10)->after('country_id');
            $table->string('continent_id', 2)->after('region_id');
            $table->index(['name', 'city']);
            $table->decimal('latitude', 11, 8)->nullable()->change();
            $table->decimal('longitude', 11, 8)->nullable()->change();
            $table->string('timezone')->nullable()->change();
            $table->string('icao', 12)->nullable(false)->change();
            $table->unique(['icao']);
            $table->foreign('country_id')->references('country_id')->on('countries')->onDelete('cascade');
            $table->foreign('region_id')->references('region_id')->on('regions')->onDelete('cascade');
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
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
            $table->dropColumn('continent_id');
            $table->dropUnique(['icao']);
            $table->dropIndex(['name', 'city']);
        });
        Schema::table('airports', function (Blueprint $table) {
            $table->string('icao', 4)->nullable()->change();
            $table->string('source_id')->nullable();
            $table->string('area', 255)->nullable();
            $table->decimal('latitude', 11, 8)->nullable(false)->change();
            $table->decimal('longitude', 11, 8)->nullable(false)->change();
            $table->string('timezone')->nullable(false)->change();

            $table->integer('country_id')->unsigned()->nullable()->after('city');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }
}
