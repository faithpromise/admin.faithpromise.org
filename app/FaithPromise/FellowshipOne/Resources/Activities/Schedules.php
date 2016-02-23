<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Activities\Schedule;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Schedules extends BaseResource {

    protected $activity_id;

    public function __construct(FellowshipOne $f1, $activity_id) {
        $this->activity_id = $activity_id;
        parent::__construct($f1);
    }

    public function all() {
        $result = $this->client->fetch('/activities/v1/activities/' . $this->activity_id . '/schedules?pagesize=1000');

        return $this->buildSimpleCollection($result, Schedule::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/activities/' . $this->activity_id . '/schedules/' . $id);

        return $result ? new Schedule($this->client, $result) : null;
    }

}