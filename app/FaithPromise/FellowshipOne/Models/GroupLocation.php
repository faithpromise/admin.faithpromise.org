<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class GroupLocation
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getDescription()
 * @method string getIsOnline()
 * @method string getUrl()
 * @method string getAddress()
 * @method string getCreatedDate()
 * @method string getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method string getLastUpdatedByPerson()
 *
 * @method GroupLocation setId($value)
 * @method GroupLocation setUri($value)
 * @method GroupLocation setName($value)
 * @method GroupLocation setDescription($value)
 * @method GroupLocation setIsOnline($value)
 * @method GroupLocation setUrl($value)
 * @method GroupLocation setAddress($value)
 * @method GroupLocation setCreatedDate($value)
 * @method GroupLocation setCreatedByPerson($value)
 * @method GroupLocation setLastUpdatedDate($value)
 * @method GroupLocation setLastUpdatedByPerson($value)
 *
 */

class GroupLocation extends Base {

    protected $attributes = [
        'id'                  => '@id',
        'uri'                 => '@uri',
        'name'                => 'name',
        'description'         => 'description',
        'isOnline'            => 'isOnline',
        'url'                 => 'url',
        'address'             => ['address', Address::class],
        'createdDate'         => 'createdDate',
        'createdByPerson'     => ['createdByPerson', Person::class],
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => ['lastUpdatedByPerson', Person::class],
    ];

}