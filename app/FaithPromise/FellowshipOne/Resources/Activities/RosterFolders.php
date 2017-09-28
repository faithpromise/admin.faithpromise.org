<?php

namespace App\FaithPromise\FellowshipOne\Resources\Activities;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Activities\RosterFolder;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;

class RosterFolders extends BaseResource {

    use SearchableResource;

    protected $activity_id;

    public function __construct(FellowshipOne $f1, $activity_id) {
        $this->activity_id = $activity_id;
        parent::__construct($f1);
    }

    public function all() {
        $result = $this->client->fetch('/activities/v1/activities/' . $this->activity_id . '/rosterfolders?pagesize=1000');

        return $this->buildSimpleCollection($result, RosterFolder::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/activities/v1/activities/' . $this->activity_id . '/rosterfolders/' . $id);

        return $result ? new RosterFolder($this->client, $result) : null;
    }

}