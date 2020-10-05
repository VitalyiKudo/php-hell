<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source_id')->nullable();
            $table->string('departure', 255);
            $table->string('arrival', 255);
            $table->string('time', 255);
            $table->unsignedDecimal('price_turbo', 11, 2)->nullable();
            $table->unsignedDecimal('price_light', 11, 2)->nullable();
            $table->unsignedDecimal('price_medium', 11, 2)->nullable();
            $table->unsignedDecimal('price_heavy', 11, 2)->nullable();
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
        Schema::dropIfExists('pricing');
    }
}
