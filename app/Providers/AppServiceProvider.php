<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
//    public function boot()
//    {
//        //
//        //\Illuminate\Support\Facades\URL::forceScheme('https');
//        Schema::defaultStringLength(191);
//    }
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
