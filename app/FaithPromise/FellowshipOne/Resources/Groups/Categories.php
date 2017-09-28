<?php

namespace App\FaithPromise\FellowshipOne\Resources\Groups;

use App\FaithPromise\FellowshipOne\Models\Groups\Category;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Categories extends BaseResource {

    public function all() {
        $result = $this->client->fetch('/groups/v1/categories');

        return $this->buildCollection($result['categories'], 'category', Category::class);
    }

    /**
     * @param $id
     * @return Category
     * @throws \App\FaithPromise\FellowshipOne\Exception
     */
    public function find($id) {
        $result = $this->client->fetch('/groups/v1/categories/' . $id);

        return $result ? new Category($this->client, $result['category']) : null;
    }

}
