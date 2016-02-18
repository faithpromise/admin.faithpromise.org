<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;

use App\FaithPromise\FellowshipOne\Models\Base;
use App\FaithPromise\FellowshipOne\Models\People\Person;

/**
 * Class GroupLocation
 * @package App\FaithPromise\FellowshipOne\Models\Groups
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
 * @method Location setId($value)
 * @method Location setUri($value)
 * @method Location setName($value)
 * @method Location setDescription($value)
 * @method Location setIsOnline($value)
 * @method Location setUrl($value)
 * @method Location setAddress($value)
 * @method Location setCreatedDate($value)
 * @method Location setCreatedByPerson($value)
 * @method Location setLastUpdatedDate($value)
 * @method Location setLastUpdatedByPerson($value)
 *
 */
class Location extends Base {

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