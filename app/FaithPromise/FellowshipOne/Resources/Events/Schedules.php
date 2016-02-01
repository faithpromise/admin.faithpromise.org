<?php

namespace App\FaithPromise\FellowshipOne\Resources\Events;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Events\Schedule;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Schedules extends BaseResource {

    protected $event_id;

    public function __construct(FellowshipOne $f1, $event_id) {
        $this->event_id = $event_id;
        $this->url = '/events/v1/events/' . $event_id . '/schedules';

        return parent::__construct($f1);
    }

    public function all() {
        $result = $this->client->fetch($this->url);

        $collection = $this->buildCollection($result['schedules'], 'schedule', Schedule::class);

//        if ($this->with_people) {
//            return $this->addPeople($collection);
//        }

        return $collection;

    }

//    public function find($id) {
//        $result = $this->client->fetch('/events/v1/events/' . $id);
//
//        return new Event($this->client, $result['event']);
//    }

}