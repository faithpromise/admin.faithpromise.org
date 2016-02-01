<?php

namespace App\FaithPromise\FellowshipOne\Resources\People;

use App\FaithPromise\FellowshipOne\Models\People\Denomination;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Denominations extends BaseResource {

    public function all() {
        $url = '/v1/People/Denominations';
        $result = $this->client->fetch($url);

        return $this->buildCollection($result['denominations'], 'denomination', Denomination::class);

    }

}