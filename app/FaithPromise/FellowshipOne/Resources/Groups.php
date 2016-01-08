<?php

namespace App\FaithPromise\FellowshipOne\Resources;

class Groups extends BaseResource {

    public function all($page = 1) {

        $url = '/groups/v1/groups/search?issearchable=true&page=' . $page;
        $result = $this->client->fetch($url);

        return [
            '@count'           => $result['groups']['@count'],
            '@pageNumber'      => $result['groups']['@pageNumber'],
            '@totalRecords'    => $result['groups']['@totalRecords'],
            '@additionalPages' => $result['groups']['@additionalPages'],
            'data'             => $result['groups']['group']
        ];
    }

    public function find($id) {

        $url = '/groups/v1/groups/' . $id;
        $result = $this->client->fetch($url);

        return [
            'data' => $result['group']
        ];

    }

}
