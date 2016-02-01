<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\People\Communication;

class Communications extends BaseResource {

    protected $person_id;
    protected $with_people = true;

    public function __construct(FellowshipOne $f1, $person_id) {
        $this->person_id = $person_id;
        $this->url = '/v1/People/' . $person_id . '/Communications';

        return parent::__construct($f1);
    }

    public function all() {
        $result = $this->client->fetch($this->url);

        return $this->buildCollection($result['communications'], 'communication', Communication::class);
    }

    public function find($id) {
        $result = $this->client->fetch($this->url . '/' . $id);

        return new Communication($this->client, $result['communication']);
    }

}
