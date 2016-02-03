<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Schedule
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getActivity()
 * @method string getName()
 * @method string getStartTime()
 * @method string getEndTime()
 *
 * @method Schedule setId($value)
 * @method Schedule setUri($value)
 * @method Schedule setActivity($value)
 * @method Schedule setName($value)
 * @method Schedule setStartTime($value)
 * @method Schedule setEndTime($value)
 *
 */
class Schedule extends Base {

    protected $attributes = [
        'id'        => 'id',
        'uri'       => 'uri',
        'activity'  => 'activity',
        'name'      => 'name',
        'startTime' => 'startTime',
        'endTime'   => 'endTime',
    ];

}