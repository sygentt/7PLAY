<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Payment routes
            Route::middleware(['web'])
                ->group(base_path('routes/payment.php'));
            
            // Admin authentication routes (no auth required)
            Route::prefix('admin')
                ->middleware(['web'])
                ->group(function () {
                    Route::middleware(['guest'])->group(function () {
                        Route::get('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
                        Route::post('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login']);
                    });
                    Route::post('/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');
                });
            
            // Admin dashboard routes (auth + admin required)
            Route::prefix('admin')
                ->middleware(['web', 'auth', 'admin'])
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register custom middleware aliases
        $middleware->alias([
            'active_user' => \App\Http\Middleware\EnsureUserIsActive::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            // 'set_locale' removed with language settings feature
        ]);
        
        // Redirect guests to appropriate login page
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            return route('login');
        });
        
        // Trust reverse proxies (e.g., ngrok) so signed URLs and scheme/host are detected correctly
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO,
        );
        
        // Exclude Midtrans webhook from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'api/midtrans/notification',
        ]);

        // Locale middleware removed; language settings feature is dropped
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
