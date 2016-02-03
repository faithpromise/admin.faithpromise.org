<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Activities\Assignment;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;

class Assignments extends BaseResource {

    use SearchableResource;

    protected $activity_id;

    public function __construct(FellowshipOne $f1, $activity_id) {
        $this->activity_id = $activity_id;

        return parent::__construct($f1);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/activities/' . $this->activity_id . '/assignments/' . $id);

        return new Assignment($this->client, $result);
    }

//        $assignmentApi = $f1->assignments();
//
//        while($assignments = $assignmentApi->paginate()) {
//
//        }
    public function paginate() {

        $result = $this->get();

        if (count($result) === 0) {
            return false;
        }

        $this->nextPage();

        return $result;

    }

    public function get() {
        $result = $this->client->fetch($this->getSearchUrl());

        return $this->buildSimpleCollection($result, Assignment::class);
    }

    private function getSearchUrl() {
        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('pagesize', $this->per_page);

        return '/activities/v1/activities/' . $this->activity_id . '/assignments?' . http_build_query($this->search_params);
    }

}