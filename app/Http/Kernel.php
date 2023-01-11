<?php

namespace App\Http;

use App\Http\Middleware\ActiveDomainMiddleware;
use App\Http\Middleware\Activity;
use App\Http\Middleware\Anon;
use App\Http\Middleware\Api;
use App\Http\Middleware\Balance;
use App\Http\Middleware\Browser;
use App\Http\Middleware\CheckSite;
use App\Http\Middleware\CmsAuthMiddleware;
use App\Http\Middleware\Cors;
use App\Http\Middleware\CrossDomainAuth;
use App\Http\Middleware\CustomThrottleRequests;
use App\Http\Middleware\Responses;
use App\Http\Middleware\SiteViews;
use App\Http\Middleware\UserMatches;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * This middleware is running during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'responses' => [
            Responses::class,
        ],
        'browser' => [
            Browser::class
        ],
        'anon' => [
            Anon::class
        ],
        'session' => [
            StartSession::class,
            ShareErrorsFromSession::class
        ],
        'cookies' => [
            Middleware\EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            Middleware\Authenticate::class
        ],
        'check_site' => [
            CheckSite::class
        ],
        'domain' => [
            ActiveDomainMiddleware::class,
        ],
        'auth_server' => [
            CrossDomainAuth::class
        ],
        'web' => [
        ],

        'webp' => [
        ],

        'api' => [
            Api::class
        ],

        'ajax' => [
        ],

        'web.nocsrf' => [
            CheckSite::class
        ],
        'cms' => [
            CmsAuthMiddleware::class
        ],
        'cors' => [
            Cors::class
        ],
        'user_matches' => [
            UserMatches::class
        ],
        'activity' => [
            Activity::class
        ],
        'site_views' => [
            SiteViews::class
        ]
    ];

    /**
     * The application's route middleware.
     *
     * This middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.auth' => AdminAuthMiddleware::class,
        'admin.guest' => RedirectIfAdminAuthenticated::class,
        'throttle' => CustomThrottleRequests::class,
        'balance' => Balance::class
    ];

    protected $middlewarePriority = [
        Responses::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        Middleware\EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        SiteViews::class,
        Middleware\Authenticate::class,
        ActiveDomainMiddleware::class,
        CheckSite::class,
        Anon::class,
        Activity::class,
        Balance::class
    ];
}
