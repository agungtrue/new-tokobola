<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    protected $middleware = [
        // App\Http\Middleware\ExampleMiddleware::class
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,

        'Member.Insert' => \App\Http\Middleware\Member\Insert::class,
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->routeMiddleware($this->routeMiddleware);
        $this->app->middleware($this->middleware);
    }
}
