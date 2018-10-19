<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    protected $middleware = [
        \Barryvdh\Cors\HandleCors::class,
        // App\Http\Middleware\ExampleMiddleware::class
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'cors' => \Barryvdh\Cors\HandleCors::class,
        'ArrQuery' => \App\Http\Middleware\QueryRoute::class,

        'Authentication.Login' => \App\Http\Middleware\Authentication\Login::class,

        'Account.MemberSignUp' => \App\Http\Middleware\Account\MemberSignUp::class,

        'Member.Insert' => \App\Http\Middleware\Member\Insert::class,
        'Member.UpdateMy' => \App\Http\Middleware\Member\UpdateMy::class,

        'Club.Insert' => \App\Http\Middleware\Club\Insert::class,
        'Club.Update' => \App\Http\Middleware\Club\Update::class,
        'Club.Delete' => \App\Http\Middleware\Club\Delete::class,

        'Liga.Insert' => \App\Http\Middleware\Liga\Insert::class,
        'Liga.Update' => \App\Http\Middleware\Liga\Update::class,
        'Liga.Delete' => \App\Http\Middleware\Liga\Delete::class,


        'Company.Insert' => \App\Http\Middleware\Company\Insert::class,

        'Loan.Insert' => \App\Http\Middleware\Loan\Insert::class,

        'Image.Upload' => \App\Http\Middleware\Image\Upload::class,
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->middleware($this->middleware);
        $this->app->routeMiddleware($this->routeMiddleware);
    }
}
