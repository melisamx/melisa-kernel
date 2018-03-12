<?php

namespace Melisa\Laravel\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->isJson() || $request->ajax()) {
            return response()->unauthenticated(false);
        }
        
        return redirect()->guest('login');
    }
    
    /**
    * Convert a validation exception into a JSON response.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Illuminate\Validation\ValidationException  $exception
    * @return \Illuminate\Http\JsonResponse
    */
   protected function invalidJson($request, ValidationException $exception)
   {
       return response()->json($exception->errors(), $exception->status);
   }
   
   /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if($request->isJson() || $request->ajax()) {
            return response()->validationException($e->validator);
        }
        
        return parent::convertValidationExceptionToResponse($e, $request);
    }
    
}
