<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Activities\Roster;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;

class Rosters extends BaseResource {

    use SearchableResource;

    protected $activity_id;

    public function __construct(FellowshipOne $f1, $activity_id) {
        $this->activity_id = $activity_id;

        // No pagination by default
        $this->perPage(1000);

        parent::__construct($f1);
    }

    public function all() {
        $result = $this->client->fetch('/activities/v1/activities/' . $this->activity_id . '/rosters');

        return $this->buildSimpleCollection($result, Roster::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/activities/' . $this->activity_id . '/rosters/' . $id);

        return $result ? new Roster($this->client, $result) : null;
    }

    public function byName($value) {
        return $this->addSearchParam('name', $value)->get();
    }

    private function get() {

        $result = $this->client->fetch($this->getSearchUrl());

        return $this->buildSimpleCollection($result, Roster::class);
    }

    private function getSearchUrl() {

        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('pagesize', $this->per_page);

        return '/activities/v1/activities/' . $this->activity_id . '/rosters/search?' . http_build_query($this->search_params);
    }

}