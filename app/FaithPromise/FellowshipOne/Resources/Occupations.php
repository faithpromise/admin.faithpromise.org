<?php

namespace App\FaithPromise\FellowshipOne\Resources;


use App\FaithPromise\FellowshipOne\Models\Occupation;

class Occupations extends BaseResource {

    public function all() {
        $url = '/v1/People/Occupations';
        $result = $this->client->fetch($url);

        return $this->buildCollection($result['occupations'], 'occupation', Occupation::class);

    }

}