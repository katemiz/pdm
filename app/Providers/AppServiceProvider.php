<?php

namespace App\Providers;

use DB;
use Log;

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

        // add this one
        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings
            );
        });



    }
}
