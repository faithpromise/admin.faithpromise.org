<?php

namespace App\FaithPromise\FellowshipOne;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    public function register() {

        $this->app->bindShared(FellowshipOneInterface::class, function () {

            // TODO: Can get rid of config/fellowshipone.php?
            return new FellowshipOne(
                env('F1_KEY'),
                env('F1_SECRET'),
                env('F1_API_URI')
            );

        });

    }

}