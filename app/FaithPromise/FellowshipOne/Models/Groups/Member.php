<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;

use App\FaithPromise\FellowshipOne\Models\Base;
use App\FaithPromise\FellowshipOne\Models\People\Person;

/**
 * Class Member
 * @package App\FaithPromise\FellowshipOne\Models\Groups
 *
 * @method string getId()
 * @method string getUri()
 * @method Group getGroup()
 * @method Person getPerson()
 * @method MemberType getMemberType()
 * @method string getCreatedDate()
 * @method Person getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method Person getLastUpdatedByPerson()
 *
 * @method Member setId($value)
 * @method Member setUri($value)
 * @method Member setGroup($value)
 * @method Member setPerson($value)
 * @method Member setMemberType($value)
 * @method Member setCreatedDate($value)
 * @method Member setCreatedByPerson($value)
 * @method Member setLastUpdatedDate($value)
 * @method Member setLastUpdatedByPerson($value)
 *
 */
class Member extends Base {

    protected $attributes = [
        'id'                  => '@id',
        'uri'                 => '@uri',
        'group'               => ['group', Group::class],
        'person'              => ['person', Person::class],
        'memberType'          => ['memberType', MemberType::class],
        'createdDate'         => 'createdDate',
        'createdByPerson'     => ['createdByPerson', Person::class],
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => ['lastUpdatedByPerson', Person::class],
    ];

    public function isLeader() {
        return $this->getMemberType()->isLeader();
    }

}