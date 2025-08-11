<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }



public function boot()
{
    // Always force https + production domain for emails
    ResetPassword::createUrlUsing(function ($notifiable, string $token) {
        $base ='https://atsdb.up.railway.app';
        return $base.'/api/password/reset/'.$token.'?email='.urlencode($notifiable->getEmailForPasswordReset());
    });
}

    /**
     * Bootstrap any application services.
     */

}
