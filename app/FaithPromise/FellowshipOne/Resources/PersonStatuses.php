<?php

namespace App\FaithPromise\FellowshipOne\Resources;


use App\FaithPromise\FellowshipOne\Models\PersonStatus;

class PersonStatuses extends BaseResource {

    public function all() {

        $url = '/v1/People/Statuses';
        $result = $this->client->fetch($url);
        dd($result);
        return $this->buildCollection($result['statuses']['status'], PersonStatus::class);

    }

}