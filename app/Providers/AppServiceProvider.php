<?php

namespace App\Providers;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
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
        RateLimiter::for('login-attempts', function (Request $request) {
            //return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());

            return Limit::perMinute(5)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    //return response('Custom response...', 429, $headers);
                    return back()->withInput()->with('status', 'Limite atingido, tente novamente em 5 minutos');
            });
        });
    }
}
