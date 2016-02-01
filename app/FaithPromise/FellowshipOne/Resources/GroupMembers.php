<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Groups\Member;

class GroupMembers extends BaseResource {

    protected $group_id;
    protected $with_people = true;

    public function __construct(FellowshipOne $f1, $group_id) {
        $this->group_id = $group_id;
        $this->url = '/groups/v1/groups/' . $group_id . '/members';

        return parent::__construct($f1);
    }

    public function find($member_id) {
        $result = $this->client->fetch('/groups/v1/groups/' . $this->group_id . '/members/' . $member_id);

        return new Member($result['member']); // TODO: test
    }

    public function withPeople($with_people = true) {
        $this->with_people = $with_people;

        return $this;
    }

    public function all() {

        $result = $this->client->fetch($this->url);
        $collection = $this->buildCollection($result['members'], 'member', Member::class);

        if ($this->with_people) {
            return $this->addPeople($collection);
        }

        return $collection;
    }

    private function addPeople(&$collection) {

        $ids = [];
        foreach ($collection as $item) {
            $ids[] = $item->getPerson()->getId();
        }

        $people = $this->client->people()->whereId($ids);

        foreach ($collection as $item) {
            $id = $item->getPerson()->getId();
            $item->setPerson($people->get($id));
        }

        return $collection;

    }

}