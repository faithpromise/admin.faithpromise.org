<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\Models\Activities\Room;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Rooms extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/activities/v1/rooms');

        return $this->buildSimpleCollection($result, Room::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/rooms/' . $id);

        return new Room($this->client, $result);
    }

}