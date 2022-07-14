<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 150)->nullable(false);
            $table->string('title', 250)->nullable(false);
            $table->string('message', 250)->nullable(false);
            $table->string('channel', 250)->nullable(false);
        });

        DB::table('notifications')->insert(['key' => 'request_update', 'title' => 'Request update notification', 'message' => 'Your Order has been changed. Please check the status', 'channel' => 'request_channel']);
        DB::table('notifications')->insert(['key' => 'order_update', 'title' => 'Order update notification', 'message' => 'We have updated information about your Request. Please check the app', 'channel' => 'order_channel']);
        DB::table('notifications')->insert(['key' => 'chat_message', 'title' => 'Chat update notification', 'message' => 'You have message in the chat. Please check', 'channel' => 'chat_channel']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
