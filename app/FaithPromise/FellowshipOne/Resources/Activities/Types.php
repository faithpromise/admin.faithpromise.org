<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\Models\Activities\Type;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Types extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/activities/v1/types');

        return $this->buildSimpleCollection($result, Type::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/types/' . $id);

        return $result ? new Type($this->client, $result) : null;
    }

}