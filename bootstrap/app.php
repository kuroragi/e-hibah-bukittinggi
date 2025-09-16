<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // dd($exceptions->render(function(AuthorizationException $e, $request) {}));
        $exceptions->render(function (AuthorizationException $e, $request) {
            if ($request->expectsJson()) {
                // Kalau request dari Livewire/Ajax
                return response()->json([
                    'redirect' => route('dashboard'),
                    'message' => 'Kamu tidak memiliki hak akses ke halaman tersebut.'
                ], 403);
            }

            return redirect()->route('dashboard')
                ->with('no_access', 'Kamu tidak memiliki hak akses ke halaman tersebut.');
        });
    })->create();
