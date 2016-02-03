<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Activities\HeadCount;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class HeadCounts extends BaseResource {

    protected $instance_id;

    public function __construct(FellowshipOne $f1, $instance_id) {
        $this->instance_id = $instance_id;

        return parent::__construct($f1);
    }

    public function all() {

        $result = $this->client->fetch('/activities/v1/instances/' . $this->instance_id . '/headcounts?pagesize=2000');

        return $this->buildSimpleCollection($result, HeadCount::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/instances/' . $this->instance_id . '/headcounts/' . $id);

        return new HeadCount($this->client, $result);
    }

}