<?php

namespace App\FaithPromise\FellowshipOne\Models\Events;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Schedule
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getDescription()
 * @method string getStartTime()
 * @method string getEndTime()
 * @method string getNumberRecurrences()
 * @method string getStartDate()
 * @method string getEndDate()
 * @method string getRecurrenceType()
 * @method string getRecurrences()
 * @method string getCreatedDate()
 * @method string getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method string getLastUpdatedByPerson()
 *
 * @method Schedule setId($value)
 * @method Schedule setUri($value)
 * @method Schedule setName($value)
 * @method Schedule setDescription($value)
 * @method Schedule setStartTime($value)
 * @method Schedule setEndTime($value)
 * @method Schedule setNumberRecurrences($value)
 * @method Schedule setStartDate($value)
 * @method Schedule setEndDate($value)
 * @method Schedule setRecurrenceType($value)
 * @method Schedule setRecurrences($value)
 * @method Schedule setCreatedDate($value)
 * @method Schedule setCreatedByPerson($value)
 * @method Schedule setLastUpdatedDate($value)
 * @method Schedule setLastUpdatedByPerson($value)
 *
 */

class Schedule extends Base {

    protected $attributes = [
        'id'                  => '@id',
        'uri'                 => '@uri',
        'name'                => 'name',
        'description'         => 'description',
        'startTime'           => 'startTime',
        'endTime'             => 'endTime',
        'numberRecurrences'   => 'numberRecurrences',
        'startDate'           => 'startDate',
        'endDate'             => 'endDate',
        'recurrenceType'      => 'recurrenceType',
        'recurrences'         => 'recurrences',
        'createdDate'         => 'createdDate',
        'createdByPerson'     => 'createdByPerson',
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => 'lastUpdatedByPerson',
    ];

}