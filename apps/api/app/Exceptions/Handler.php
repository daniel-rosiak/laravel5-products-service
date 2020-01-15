<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Route;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->ajax() || $request->wantsJson())
        {
            $json = [
                'success' => false,
                'error' => [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ],
            ];
            return response()->json($json, 400);
        }

        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json([
                'error' => 'Unauthorized.'
            ], 401);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'error' => 'Forbidden.'
            ], 403);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource item not found.'
            ], 404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Resource not found.'
            ], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => 'Method not allowed.'
            ], 405);
        }


        return parent::render($request, $exception);
    }
}
