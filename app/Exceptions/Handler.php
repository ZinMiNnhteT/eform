<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        // $uri = $_SERVER['REQUEST_URI'];
        // if (str_contains($uri, '/api/')) { 
        //     if($exception instanceof NotFoundHttpException) {
        //         return response()->json(['success' => false,'title'=> 'PageNotFound','message'=>'The requested url is not found.', 'exception' => class_basename($exception)], 404);
        //     }
        //     else if($exception instanceof UnauthorizedHttpException) {
        //         return response()->json(['success' => false,'title'=>'Unauthorized', 'message' => 'Your login time is expired. Please login again', 'exception' => class_basename($exception)], 403);
        //     }else{
        //         return response()->json(['success' => false,'title'=>'ServerError', 'message' => 'A server error currently occur. Please wait until the developer teams fix it.', 'exception' => class_basename($exception)], 500);
        //     }
        // }
        return parent::render($request, $exception);
    }

    /* 
    * Custom Exception Unauthenticated Function
    */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is('dashboard')) {
            return redirect()->guest('/login/moee');
        }
        return redirect()->guest(route('login'));
    }

    public function apiRender($request, AuthenticationException $exception)
    {
        if($exception instanceof UnauthorizedHttpException) {
            return response()->json(['success' => 'false','message'=>'Unauthorized'], 403);
        }

        // $this->renderable(function(TokenInvalidException $e, $request){
        //         return Response::json(['error'=>'Invalid token'],401);
        // });
        // $this->renderable(function (TokenExpiredException $e, $request) {
        //     return Response::json(['error'=>'Token has Expired'],401);
        // });

        // $this->renderable(function (JWTException $e, $request) {
        //     return Response::json(['error'=>'Token not parsed'],401);
        // });

    }
}
