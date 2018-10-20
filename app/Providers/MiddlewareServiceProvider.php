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

        'Blog.Insert' => \App\Http\Middleware\Blog\Insert::class,
        'Blog.Update' => \App\Http\Middleware\Blog\Update::class,
        'Blog.Delete' => \App\Http\Middleware\Blog\Delete::class,

        'Produk.Insert' => \App\Http\Middleware\Produk\Insert::class,
        'Produk.Update' => \App\Http\Middleware\Produk\Update::class,
        'Produk.Delete' => \App\Http\Middleware\Produk\Delete::class,

        'Order.Insert' => \App\Http\Middleware\Order\Insert::class,
        'Order.Update' => \App\Http\Middleware\Order\Update::class,
        'Order.Delete' => \App\Http\Middleware\Order\Delete::class,

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
