<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNotificationsChannelValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('notifications')->truncate();

        DB::table('notifications')->insert(['key' => 'request_update', 'title' => 'Request update notification', 'message' => 'Your Order has been changed. Please check the status', 'channel' => 'requests']);
        DB::table('notifications')->insert(['key' => 'order_update', 'title' => 'Order update notification', 'message' => 'We have updated information about your Request. Please check the app', 'channel' => 'orders']);
        DB::table('notifications')->insert(['key' => 'chat_message', 'title' => 'Chat update notification', 'message' => 'You have message in the chat. Please check', 'channel' => 'chats']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('notifications')->truncate();

        DB::table('notifications')->insert(['key' => 'request_update', 'title' => 'Request update notification', 'message' => 'Your Order has been changed. Please check the status', 'channel' => 'request_channel']);
        DB::table('notifications')->insert(['key' => 'order_update', 'title' => 'Order update notification', 'message' => 'We have updated information about your Request. Please check the app', 'channel' => 'order_channel']);
        DB::table('notifications')->insert(['key' => 'chat_message', 'title' => 'Chat update notification', 'message' => 'You have message in the chat. Please check', 'channel' => 'chat_channel']);
    }
}
