<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Models\Group;

class Groups extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/groups/v1/groups/search?issearchable=true&recordsPerPage=5'); // TODO: recordsPerPage=9999999
        return $this->buildCollection($result['groups']['group'], Group::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/groups/v1/groups/' . $id);
        return new Group($this->client, $result['group']);
    }

    /**
     * @return Group
     */
    public function context($id) {
        $model = new Group($this->client);
        return $model->setId($id);
    }

}
