<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use Illuminate\Support\Collection;

class BaseResource {

    protected $url;

    public function __construct(FellowshipOne $f1) {
        $this->client = $f1;
    }

    protected function buildCollection($data, $results_property, $model) {

        $collection = new Collection;

        if (! array_key_exists($results_property, $data)) {
            return $collection;
        }

        foreach ($data[$results_property] as $record) {
            $item = new $model($this->client, $record);
            $collection->put($record['@id'], $item);
        }

        return $collection;

    }

}