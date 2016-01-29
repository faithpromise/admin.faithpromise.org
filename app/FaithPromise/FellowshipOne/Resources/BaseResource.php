<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use Illuminate\Support\Collection;

class BaseResource {

    protected $url;
    protected $page = 1;
    protected $per_page = 1000;

    public function __construct(FellowshipOne $f1) {
        $this->client = $f1;
    }

    protected function buildCollection($data, $model) {

        $collection = new Collection;

        foreach ($data as $record) {
            $item = new $model($this->client, $record);
            $collection->put($record['@id'], $item);
        }

        return $collection;

    }

}