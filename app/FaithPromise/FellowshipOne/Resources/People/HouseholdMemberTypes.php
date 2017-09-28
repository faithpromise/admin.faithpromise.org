<?php

namespace App\FaithPromise\FellowshipOne\Resources\People;

use App\FaithPromise\FellowshipOne\Models\People\HouseholdMemberType;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class HouseholdMemberTypes extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/v1/People/HouseholdMemberTypes');

        return $this->buildCollection($result['householdMemberTypes'], 'householdMemberType', HouseholdMemberType::class);

    }

}