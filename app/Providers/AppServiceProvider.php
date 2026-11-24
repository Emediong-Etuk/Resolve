<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $this->configurePasswords();
        $this->configureRateLimiting();
    }


    public function configurePasswords():void
    {
        Password::defaults(function (): Password{
            return app()->environment('production')
            ? Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised():Password::min(8);
        });
    }

    public function configureRateLimiting():void
    {

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('token', function (Request $request) {
            $token = (string) $request->token;

            return Limit::perMinute(5)->by($token.$request->ip());
        });

        RateLimiter::for('signup', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('forgot-password', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('api-two-factor', function(Request $request){
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}

