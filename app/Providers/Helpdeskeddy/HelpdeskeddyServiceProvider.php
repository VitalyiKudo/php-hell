<?php

namespace App\Providers\Helpdeskeddy;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class HelpdeskeddyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('helpdeskeddy', function ($app) {
            $key = base64_encode($app->config->get('services.helpdeskeddy.key'));

            $http = new HttpClient([
                'base_uri' => $app->config->get('services.helpdeskeddy.url'),
                'headers' => [
                    'Authorization' => "Basic {$key}",
                ],
            ]);

            return new Helpdeskeddy($http);
        });
    }
}
