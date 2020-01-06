<?php

namespace App\Providers\Authorize;

use Illuminate\Support\ServiceProvider;
use net\authorize\api\contract\v1\MerchantAuthenticationType;

class AuthorizeServiceProvider extends ServiceProvider
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
        $this->app->bind('authorize', function ($app) {
            $loginId = $app->config->get('services.authorize.login_id');
            $transactionKey = $app->config->get('services.authorize.transaction_key');

            return new Anet($loginId, $transactionKey);
        });
    }
}
