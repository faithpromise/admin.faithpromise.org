<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Models\GroupCategory;

class GroupCategories extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/groups/v1/categories');
        return $this->buildCollection($result['categories']['category'], GroupCategory::class);
    }

    /**
     * @param $id
     * @return GroupCategory
     * @throws \App\FaithPromise\FellowshipOne\Exception
     */
    public function find($id) {
        $result = $this->client->fetch('/groups/v1/categories/' . $id);
        return new GroupCategory($this->client, $result['category']);
    }

}
