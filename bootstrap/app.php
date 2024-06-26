<?php


use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthDoctor;
use App\Http\Middleware\GuestAdmin;
use App\Http\Middleware\GuestDoctor;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->group(base_path('routes/AdminDashboardRoutes.php'));
            Route::middleware('web')->group(base_path('routes/DoctorDashboardRoutes.php'));

        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'auth.admin' => AuthAdmin::class,
            'auth.doctor' => AuthDoctor::class,
            'guest.admin'=>GuestAdmin::class,
            'guest.doctor'=>GuestDoctor::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
