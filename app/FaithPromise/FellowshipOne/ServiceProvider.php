<?php

namespace App\FaithPromise\FellowshipOne;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    public function register() {

        $this->app->singleton(FellowshipOneInterface::class, function () {

            // TODO: Can get rid of config/fellowshipone.php?
            return new FellowshipOne(
                config('fellowshipone.key'),
                config('fellowshipone.secret'),
                config('fellowshipone.api_url')
            );

        });

    }

}