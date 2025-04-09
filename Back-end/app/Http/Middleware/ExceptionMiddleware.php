<?php

namespace App\Http\Middleware;

use Closure;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class ExceptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (Throwable $exception) {
            return match (true) {
                $exception instanceof ModelNotFoundException =>
                    response()->json(['error' => 'Resource Not Found'], Response::HTTP_NOT_FOUND),
                $exception instanceof AuthenticationException =>
                    response()->json(['error' => 'Unauthorized access'], Response::HTTP_UNAUTHORIZED),
                $exception instanceof AuthorizationException =>
                    response()->json(['error' => 'Forbidden: You do not have permission'], Response::HTTP_FORBIDDEN),
                $exception instanceof ValidationException =>
                    response()->json(['error' => $exception->errors()], Response::HTTP_UNPROCESSABLE_ENTITY),
                $exception instanceof TooManyRequestsHttpException =>
                    response()->json(['error' => 'Too many requests, please slow down'], Response::HTTP_TOO_MANY_REQUESTS),
                default =>
                    response()->json(['error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR),
            };
        }
    }
}
