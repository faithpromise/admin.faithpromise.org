<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Models\School;

class Schools extends BaseResource {

    public function all() {
        $url = '/v1/People/Schools';
        $result = $this->client->fetch($url);

        return $this->buildCollection($result['schools']['school'], School::class);

    }

}