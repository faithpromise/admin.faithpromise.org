<?php

namespace App\FaithPromise\FellowshipOne;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use OAuth;

class ServiceProvider extends BaseServiceProvider {

    public function register() {

        $this->app->bindShared(ClientInterface::class, function ($app) {

            $oauth_client = new OAuth($app['config']['fellowshipone']['key'], $app['config']['fellowshipone']['secret']);
            return new Client($oauth_client, env('F1_API_URI'));

        });

    }

}