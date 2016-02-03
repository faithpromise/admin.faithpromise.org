<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Activities\Activity;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;

class Activities extends BaseResource {

    use SearchableResource;

    public function __construct(FellowshipOne $f1) {

        parent::__construct($f1);

        // No pagination by default
        $this->perPage(10000);
    }

    public function all() {
        $result = $this->client->fetch('/activities/v1/activities?pagesize=' . $this->per_page);

        return $this->buildSimpleCollection($result, Activity::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/activities/' . $id);

        return new Activity($this->client, $result);
    }

    public function byMinistry($id) {
        return $this->addSearchParam('ministryid', $id)->get();
    }


    /*
    |--------------------------------------------------------------------------
    | Get
    |--------------------------------------------------------------------------
    |
    | Get the results. At least one criteria must be provided
    |
    */

    public function get() {

        if (!$this->hasSearchParameters()) {
            throw new \Exception('At least one criteria must be provided to search groups.');
        }

        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('pagesize', $this->per_page);
        $result = $this->client->fetch('/activities/v1/activities/search?' . http_build_query($this->search_params));

        return $this->buildSimpleCollection($result, Activity::class);
    }

}