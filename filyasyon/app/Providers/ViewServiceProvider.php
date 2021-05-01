<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
    public function boot(Guard $auth)
    {
        View::composer('*', function ($view) use ($auth) {
            $view->with('user', $auth->user());
        });
    }
}
