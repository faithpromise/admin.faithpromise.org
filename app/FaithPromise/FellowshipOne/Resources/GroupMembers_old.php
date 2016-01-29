<?php

namespace App\FaithPromise\FellowshipOne\Resources;

class GroupMembers_old extends BaseResource {

    public function all($group_id) {
        $url = '/groups/v1/groups/' . $group_id . '/members';
        $result = $this->client->fetch($url);

        return [
            'data' => $result['members']['member']
        ];
    }

    public function find($id) {
        $url = '/groups/v1/categories/' . $id;
        $result = $this->client->fetch($url);

        return [
            'data' => $result['category']
        ];
    }

}