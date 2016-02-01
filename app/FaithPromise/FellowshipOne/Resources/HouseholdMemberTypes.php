<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Models\HouseholdMemberType;

class HouseholdMemberTypes extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/v1/People/HouseholdMemberTypes');

        return $this->buildCollection($result['householdMemberTypes'], 'householdMemberType', HouseholdMemberType::class);

    }

}