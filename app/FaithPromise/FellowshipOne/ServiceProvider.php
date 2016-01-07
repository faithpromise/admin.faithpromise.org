<?php

namespace App\FaithPromise\FellowshipOne;

use App\FaithPromise\FellowshipOne\Client as FellowshipOneApi;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    public function register() {

        $this->app->bindShared(ClientInterface::class, function () {

            // TODO: Can get rid of config/fellowshipone.php?
            return new FellowshipOneApi(
                env('F1_KEY'),
                env('F1_SECRET'),
                env('F1_API_URI')
            );

        });

    }

}