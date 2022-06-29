<?php

namespace App\Providers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Client;
use Laravel\Telescope\TelescopeServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Schema::defaultStringLength(191);

        $baseUrl = env('AVINODE_API_BASE_URL');

        $this->app->singleton('GuzzleHttp\Client', function($api) use ($baseUrl) {
            return new Client([
                'base_uri' => $baseUrl,
            ]);
        });

        if ($this->app->environment() === 'local') {
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        else {
            $this->app->register(\HTMLMin\HTMLMin\HTMLMinServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ResetPassword::$toMailCallback = function($notifiable, $token) {
            return (new MailMessage)
                ->subject(Lang::getFromJson('Reset Password Notification'))
                ->line(Lang::getFromJson('You are receiving this email because we received a password reset request for your account.'))
                ->action(Lang::getFromJson('Reset Password'), url(config('app.url').route('client.password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
                ->line(Lang::getFromJson('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(Lang::getFromJson('If you did not request a password reset, no further action is required.'));
        };
    }
}
