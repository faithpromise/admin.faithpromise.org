<?php

namespace App\FaithPromise\FellowshipOne\Resources\Groups;

use App\FaithPromise\FellowshipOne\Models\Groups\MemberType;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class MemberTypes extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/groups/v1/membertypes');

        return $this->buildCollection($result['memberTypes'], 'memberType', MemberType::class);
    }

    /**
     * @param $id
     * @return MemberType
     * @throws \App\FaithPromise\FellowshipOne\Exception
     */
    public function find($id) {
        $result = $this->client->fetch('/groups/v1/membertypes/' . $id);

        return new MemberType($this->client, $result['memberType']);
    }

}
