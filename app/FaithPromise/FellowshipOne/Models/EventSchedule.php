<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class EventSchedule
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
 * @method string setId($value)
 * @method string setUri($value)
 * @method string setName($value)
 * @method string setDescription($value)
 * @method string setStartTime($value)
 * @method string setEndTime($value)
 * @method string setNumberRecurrences($value)
 * @method string setStartDate($value)
 * @method string setEndDate($value)
 * @method string setRecurrenceType($value)
 * @method string setRecurrences($value)
 * @method string setCreatedDate($value)
 * @method string setCreatedByPerson($value)
 * @method string setLastUpdatedDate($value)
 * @method string setLastUpdatedByPerson($value)
 *
 */

class EventSchedule extends Base {

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