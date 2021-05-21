<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('order_status_id')->unsigned();
            $table->integer('search_result_id')->unsigned();
            $table->text('comment')->nullable();
            $table->decimal('price', 11, 2);
            $table->string('billing_address');
            $table->string('billing_address_secondary')->nullable();
            $table->string('billing_country');
            $table->string('billing_city');
            $table->string('billing_province')->nullable();
            $table->string('billing_postcode');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
            $table->foreign('search_result_id')->references('id')->on('searches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
