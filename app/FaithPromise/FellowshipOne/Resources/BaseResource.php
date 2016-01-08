<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Client as ZendeskApi;

class BaseResource {

    public function __construct(ZendeskApi $client) {

        $this->client = $client;

    }

}