<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldTypeAndNameSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('searches', function (Blueprint $table) {
            /*
            $table->dropForeign('searches_end_airport_id_foreign');
            $table->dropIndex('searches_end_airport_id_foreign');		
            $table->dropForeign(['start_airport_id']);
            $table->dropForeign(['end_airport_id']);
            $table->dropForeign('start_airport_id_foreign');
            $table->dropForeign('end_airport_id_foreign');
            */
            $table->string('start_airport_id')->nullable()->change();
            $table->string('end_airport_id')->nullable()->change();
            $table->renameColumn('start_airport_id', 'start_airport_name');
            $table->renameColumn('end_airport_id', 'end_airport_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
