<?php

namespace JobApis\JobsToMail\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use JobApis\JobsToMail\Http\Middleware\VerifyLogin;
use JobApis\JobsToMail\Http\Middleware\VerifyLogout;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \JobApis\JobsToMail\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \JobApis\JobsToMail\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \JobApis\JobsToMail\Http\Middleware\UpdateSessionUser::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => VerifyLogin::class,
        'non-auth' => VerifyLogout::class,
    ];
}
