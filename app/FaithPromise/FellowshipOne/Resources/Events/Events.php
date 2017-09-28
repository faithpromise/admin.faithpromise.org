<?php

namespace App\FaithPromise\FellowshipOne\Resources\Events;

use App\FaithPromise\FellowshipOne\Models\Events\Event;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Events extends BaseResource {

    public function all() {
        $url = '/events/v1/events';
        $result = $this->client->fetch($url);

        return $this->buildCollection($result['events'], 'event', Event::class);

    }

    public function find($id) {
        $result = $this->client->fetch('/events/v1/events/' . $id);

        return $result ? new Event($this->client, $result['event']) : null;
    }

}