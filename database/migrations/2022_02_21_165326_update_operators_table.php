<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('operators');
        Schema::create('operators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255)->unique();
            #$table->string('email_other', 255)->nullable();
            $table->string('name', 255)->index();
            $table->boolean('active')->index()->default(0);
            $table->string('web_site', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('mobile', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operators');
        Schema::create('operators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source_id')->nullable();
            $table->string('name', 255);
            $table->string('web_site', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('mobile', 255);
            $table->string('fax', 255);
            $table->text('address');
            $table->timestamps();
        });
    }
}
