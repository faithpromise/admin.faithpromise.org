<?php

namespace App\FaithPromise\FellowshipOne\Models\Events;
use App\FaithPromise\FellowshipOne\Models\Base;
use App\FaithPromise\FellowshipOne\Models\People\Person;

/**
 * Class Event
 * @package App\FaithPromise\FellowshipOne\Models\Events
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getDescription()
 * @method string getCreatedDate()
 * @method Person getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method Person getLastUpdatedByPerson()
 *
 * @method Event setId($value)
 * @method Event setUri($value)
 * @method Event setName($value)
 * @method Event setDescription($value)
 * @method Event setCreatedDate($value)
 * @method Event setCreatedByPerson($value)
 * @method Event setLastUpdatedDate($value)
 * @method Event setLastUpdatedByPerson($value)
 *
 */

class Event extends Base {

    protected $attributes = [
        'id'                  => '@id',
        'uri'                 => '@uri',
        'name'                => 'name',
        'description'         => 'description',
        'createdDate'         => 'createdDate',
        'createdByPerson'     => ['createdByPerson', Person::class],
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => ['lastUpdatedByPerson', Person::class],
    ];

}