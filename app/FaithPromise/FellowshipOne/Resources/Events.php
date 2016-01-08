<?php

namespace App\FaithPromise\FellowshipOne\Resources;


class Events extends BaseResource {

    public function find($id) {
        $url = '/events/v1/events/' . $id;
        $result = $this->client->fetch($url);

        return $result;
    }

}