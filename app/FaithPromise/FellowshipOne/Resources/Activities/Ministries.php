<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\Models\Activities\Ministry;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Ministries extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/activities/v1/ministries?pagesize=10000');

        return $this->buildSimpleCollection($result, Ministry::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/ministries/' . $id);

        return $result ? new Ministry($this->client, $result) : null;
    }

}