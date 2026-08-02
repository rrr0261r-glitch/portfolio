<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //register the middleware to use it in routes
        $middleware->appendToGroup('admin', [AdminMiddleware::class]);
        //      appendtoGroup('group_name', middleware)
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

?>
