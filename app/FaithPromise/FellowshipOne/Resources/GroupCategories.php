<?php

namespace App\FaithPromise\FellowshipOne\Resources;

class GroupCategories extends BaseResource {

    public function all() {
        $url = '/groups/v1/categories';
        $result = $this->client->fetch($url);

        return [
            'data' => $result['categories']['category']
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