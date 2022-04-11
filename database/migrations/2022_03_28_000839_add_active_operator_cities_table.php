<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveOperatorCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operator_cities', function (Blueprint $table) {
            $table->boolean('active')->index()->default(1)->after('geoNameIdCity');
            $table->softDeletes();
        });
        Schema::table('operators', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operator_cities', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropSoftDeletes();
        });
        Schema::table('operators', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
