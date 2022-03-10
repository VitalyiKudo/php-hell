<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Broadcast::routes();
        //Broadcast::routes(['middleware' => ['web', 'auth:admin,client']]);
        Broadcast::routes(['middleware' => ['web', 'api', 'auth:admin,client,api,api_admin']]);

        require base_path('routes/channels.php');
    }
}
