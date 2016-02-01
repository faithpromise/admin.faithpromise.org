<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Models\People\Status;

class PersonStatuses extends BaseResource {

    public function all() {

        $url = '/v1/People/Statuses';
        $result = $this->client->fetch($url);
        return $this->buildCollection($result['statuses'], 'status', Status::class);

    }

}