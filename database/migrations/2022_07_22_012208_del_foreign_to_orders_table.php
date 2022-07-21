<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelForeignToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['operator_id']);
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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }
}
