<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Instance
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getSchedule()
 * @method string getActivity()
 * @method string getStartDateTime()
 * @method string getStartCheckin()
 * @method string getEndCheckin()
 *
 * @method Instance setId($value)
 * @method Instance setUri($value)
 * @method Instance setSchedule($value)
 * @method Instance setActivity($value)
 * @method Instance setStartDateTime($value)
 * @method Instance setStartCheckin($value)
 * @method Instance setEndCheckin($value)
 *
 */
class Instance extends Base {

    protected $attributes = [
        'id'            => 'id',
        'uri'           => 'uri',
        'schedule'      => 'schedule',
        'activity'      => 'activity',
        'startDateTime' => 'startDateTime',
        'startCheckin'  => 'startCheckin',
        'endCheckin'    => 'endCheckin',
    ];

}