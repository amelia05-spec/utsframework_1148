<?php

namespace App\Providers;

use App\Guards\JwtGuard;
use App\Services\JwtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Auth::extend('jwt-driver', function ($app, $name, array $config) {
            $guard = new JwtGuard(
                userProvider: Auth::createUserProvider($config['provider']),
                request: $app->make(Request::class),
                jwtService: $app->make(JwtService::class)
            );
            $app->refresh('request', $guard, 'setRequest');
            return $guard;
        });
    }
}
