<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Tymon\JWTAuth\Middleware\GetUserFromToken;
use Tymon\JWTAuth\Middleware\RefreshToken;

class Kernel extends HttpKernel {
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'jwt.auth'    => GetUserFromToken::class,
        'jwt.refresh' => RefreshToken::class,
        'zendesk.user_id' => Middleware\ZendeskUserId::class
    ];
}
