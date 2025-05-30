<?php

use App\Helpers\Api;
use App\Jobs\UpdateRekapJurnalJob;
use Illuminate\Http\Request;
use App\Jobs\UpdateRekapAlfaJob;
use App\Jobs\UpdateRekapHadirJob;
use App\Jobs\UpdateRekapCabangJob;
use App\Jobs\UpdateRekapPerusahaanJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Database\QueryException;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'checkRoles' => \App\Http\Middleware\CheckRole::class,
            'checkViewRoles' => \App\Http\Middleware\CheckViewOnlyRole::class,

        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        // $schedule->job(new UpdateRekapAlfaJob)->dailyAt('00:00');
        // $schedule->job(new UpdateRekapHadirJob)->dailyAt('09:00');
        // $schedule->job(new UpdateRekapJurnalJob)->dailyAt('00:00');
        $schedule->job(new UpdateRekapAlfaJob)->everyMinute();
        $schedule->job(new UpdateRekapHadirJob)->everyMinute();
        $schedule->job(new UpdateRekapJurnalJob)->everyMinute();
        $schedule->job(new UpdateRekapCabangJob)->everyMinute();
        $schedule->job(new UpdateRekapPerusahaanJob)->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (Throwable $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
        });

        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if (!$request->is('api/*')) {
                return null;
            }
            if (str_contains($e->getMessage(), 'Route [login] not defined')) {
                return Api::response(null, 'Unauthorized access. Please include your token.', Response::HTTP_UNAUTHORIZED, [], 'error');
            }


            // Custom API error responses
            switch (true) {
                case $e instanceof ModelNotFoundException:
                case $e instanceof NotFoundHttpException:
                    return Api::response(null, 'Resource Not Found '. $e->getMessage(), Response::HTTP_NOT_FOUND, [], 'error');

                case $e instanceof ValidationException:
                    return Api::response(null, 'Validation failed '. $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, $e->errors(), 'error');

                case $e instanceof AuthenticationException:
                    return Api::response(null, 'Unauthorized access '. $e->getMessage(), Response::HTTP_UNAUTHORIZED, [], 'error');

                case $e instanceof AuthorizationException:
                    return Api::response(null, 'Forbidden: You do not have permission '. $e->getMessage(), Response::HTTP_FORBIDDEN, [], 'error');

                case $e instanceof TooManyRequestsHttpException:
                case $e instanceof ThrottleRequestsException:
                    return Api::response(null, 'Too many requests, please slow down ' . $e->getMessage(), Response::HTTP_TOO_MANY_REQUESTS, [], 'error');

                case $e instanceof QueryException:
                    return Api::response(null, 'A database error occurred ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, [], 'error');

                case $e instanceof HttpException:
                    $status = $e->getStatusCode();
                    $message = match ($status) {
                        Response::HTTP_NOT_FOUND => 'Resource Not Found '. $e->getMessage(),
                        Response::HTTP_UNAUTHORIZED => 'Unauthorized access '. $e->getMessage(),
                        Response::HTTP_FORBIDDEN => 'Forbidden: You do not have permission '. $e->getMessage(),
                        Response::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error '. $e->getMessage(),
                        Response::HTTP_BAD_REQUEST => 'Bad Request '. $e->getMessage(),
                        Response::HTTP_UNPROCESSABLE_ENTITY => 'Unprocessable Entity '. $e->getMessage(),
                        Response::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed '. $e->getMessage(),
                        Response::HTTP_NOT_ACCEPTABLE => 'Not Acceptable '. $e->getMessage(),
                        Response::HTTP_CONFLICT => 'Conflict '. $e->getMessage(),
                        Response::HTTP_PRECONDITION_FAILED => 'Precondition Failed '. $e->getMessage(),
                        Response::HTTP_UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type '. $e->getMessage(),
                        default => 'Unknown Error ' . $e->getMessage(),
                    };

                    return Api::response(null, $message, $status, [], 'error');

                case $e instanceof RuntimeException:
                    return Api::response(null, 'Runtime error occurred '. $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, [], 'error');

                default:
                    $status = $e instanceof HttpException
                        ? $e->getStatusCode()
                        : Response::HTTP_INTERNAL_SERVER_ERROR;

                    return Api::response(
                        null,
                        $e->getMessage() ?: 'Something went wrong',
                        $status,
                        config('app.debug') ? ['trace' => $e->getTrace()] : [],
                        'error'
                    );
            }
        });
    })->create();

