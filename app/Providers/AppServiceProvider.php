<?php

namespace App\Providers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

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
