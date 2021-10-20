<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('country_id', 3)->after('id')->unique();
            $table->string('a2', 3)->change();
            $table->string('a3', 3)->change();
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->renameColumn('a2', 'iso2');
            $table->renameColumn('a3', 'iso3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('iso2', 191)->change();
            $table->string('iso3', 191)->change();
            $table->dropUnique(['country_id']);
            $table->dropColumn('country_id');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->renameColumn('iso2', 'a2');
            $table->renameColumn('iso3', 'a3');
        });
    }
}
