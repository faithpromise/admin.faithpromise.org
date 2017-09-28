<?php

namespace App\FaithPromise\FellowshipOne\Resources\People;

use App\FaithPromise\FellowshipOne\Models\People\School;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Schools extends BaseResource {

    public function all() {
        $url = '/v1/People/Schools';
        $result = $this->client->fetch($url);

        return $this->buildCollection($result['schools'], 'school', School::class);

    }

}