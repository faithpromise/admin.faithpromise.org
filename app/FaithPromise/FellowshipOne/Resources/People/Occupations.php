<?php

namespace App\FaithPromise\FellowshipOne\Resources\People;


use App\FaithPromise\FellowshipOne\Models\People\Occupation;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Occupations extends BaseResource {

    public function all() {
        $url = '/v1/People/Occupations';
        $result = $this->client->fetch($url);

        return $this->buildCollection($result['occupations'], 'occupation', Occupation::class);

    }

}