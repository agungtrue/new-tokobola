<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Support\Response\Json;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Json::set('timestamp', Carbon::now());
        Json::set('environment', env('APP_ENV'));
        app('translator')->setLocale('id');
    }
}
