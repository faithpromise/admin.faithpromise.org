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
 * @method string setId($value)
 * @method string setUri($value)
 * @method Group setGroup($value)
 * @method Person setPerson($value)
 * @method string setMemberType($value)
 * @method string setCreatedDate($value)
 * @method string setCreatedByPerson($value)
 * @method string setLastUpdatedDate($value)
 * @method string setLastUpdatedByPerson($value)
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