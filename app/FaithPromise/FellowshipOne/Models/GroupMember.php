<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class Member
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method Group getGroup()
 * @method Person getPerson()
 * @method string getMemberType()
 * @method string getCreatedDate()
 * @method string getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method string getLastUpdatedByPerson()
 *
 * @method GroupMember setId($value)
 * @method GroupMember setUri($value)
 * @method GroupMember setGroup($value)
 * @method GroupMember setPerson($value)
 * @method GroupMember setMemberType($value)
 * @method GroupMember setCreatedDate($value)
 * @method GroupMember setCreatedByPerson($value)
 * @method GroupMember setLastUpdatedDate($value)
 * @method GroupMember setLastUpdatedByPerson($value)
 *
 */

class GroupMember extends Base {

    protected $attributes = [
        'id'                  => '@id',
        'uri'                 => '@uri',
        'group'               => ['group', Group::class],
        'person'              => ['person', Person::class],
        'memberType'          => 'memberType',
        'createdDate'         => 'createdDate',
        'createdByPerson'     => 'createdByPerson',
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => 'lastUpdatedByPerson',
    ];

}