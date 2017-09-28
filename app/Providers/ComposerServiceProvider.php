<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @param Request $request
     */
    public function boot(Request $request) {

        view()->composer('index', function($view) use ($request) {

            $jwt_token = $request->cookie('jwt');

            if ($jwt_token) {

                try {
                    $user = JWTAuth::authenticate($jwt_token);
                    $view->with('user', $user);
                } catch (\Exception $e) {

                }

            }

        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
