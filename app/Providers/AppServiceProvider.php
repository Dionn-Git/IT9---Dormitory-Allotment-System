<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
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
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        View::composer('layouts.navigation', function ($view) {
            if (Auth::check() && Auth::user()->role === 'student') {
                $unreadCount = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                $view->with('unreadCount', $unreadCount);
            }
        });
    }
}