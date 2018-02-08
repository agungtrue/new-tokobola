<?php

namespace App\Exceptions;

use Exception;
use App\Support\Response\Json;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        Json::set('exception.name',
            (new \ReflectionClass($exception))->getShortName()
        );
        if($exception instanceof NotFoundHttpException) {
            Json::set('exception.filelocation', $exception->getFile());
            Json::set('exception.line', $exception->getLine());
            return response()->json(Json::get(), 404);
        } elseif($exception instanceof MethodNotAllowedHttpException) {
            // method not allowed
            Json::set('exception.filelocation', $exception->getFile());
            Json::set('exception.line', $exception->getLine());
            return response()->json(Json::get(), 405);
        } else {
            Json::set('exception.filelocation', $exception->getFile());
            Json::set('exception.line', $exception->getLine());
            Json::set('exception.name', get_class($exception));
            return response()->json(Json::get(), 500);
        }
    }
}
