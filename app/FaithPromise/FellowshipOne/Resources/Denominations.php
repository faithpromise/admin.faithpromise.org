<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Models\Denomination;

class Denominations extends BaseResource {

    public function all() {
        $url = '/v1/People/Denominations';
        $result = $this->client->fetch($url);

        return $this->buildCollection($result['denominations']['denomination'], Denomination::class);

    }

}