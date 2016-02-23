<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Activities\Instance;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;

class Instances extends BaseResource {

    use SearchableResource;

    protected $schedule_id;

    public function __construct(FellowshipOne $f1, $schedule_id) {
        $this->schedule_id = $schedule_id;

        $this->perPage(2000);

        return parent::__construct($f1);
    }

    public function all() {
        $result = $this->client->fetch('/activities/v1/schedules/' . $this->schedule_id . '/instances?pagesize=' . $this->per_page);

        return $this->buildSimpleCollection($result, Instance::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/schedules/' . $this->schedule_id . '/instances/' . $id);

        return $result ? new Instance($this->client, $result) : null;
    }

    public function byDate($value) {
        return $this->addDateParam('name', $value)->get();
    }

    private function get() {

        $result = $this->client->fetch($this->getSearchUrl());

        return $this->buildSimpleCollection($result, Instance::class);
    }

    private function getSearchUrl() {

        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('pagesize', $this->per_page);

        return '/activities/v1/schedules/' . $this->schedule_id . '/instances/search?' . http_build_query($this->search_params);
    }

}