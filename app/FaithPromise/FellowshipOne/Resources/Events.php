<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Models\Events\Event;

class Events extends BaseResource {

    public function all() {
        $url = '/events/v1/events';
        $result = $this->client->fetch($url);

        return $this->buildCollection($result['events'], 'event', Event::class);

    }

    public function find($id) {
        $result = $this->client->fetch('/events/v1/events/' . $id);

        return new Event($this->client, $result['event']);
    }

}