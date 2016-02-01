<?php

namespace App\FaithPromise\FellowshipOne\Resources\People;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\People\Address;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;

class Addresses extends BaseResource {

    protected $person_id;
    protected $with_people = true;

    public function __construct(FellowshipOne $f1, $person_id) {
        $this->person_id = $person_id;
        $this->url = '/v1/People/' . $person_id . '/Addresses';

        return parent::__construct($f1);
    }

    public function all() {
        $result = $this->client->fetch($this->url);
        return $this->buildCollection($result['addresses'], 'address', Address::class);
    }

    public function find($id) {
        $result = $this->client->fetch($this->url . '/' . $id);
        return new Address($this->client, $result['address']);
    }

}
