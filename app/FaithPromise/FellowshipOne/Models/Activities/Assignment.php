<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Assignment
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getType()
 * @method string getPerson()
 * @method string getActivity()
 * @method string getSchedule()
 * @method string getRoster()
 * @method string getRosterFolder()
 *
 * @method Assignment setId($value)
 * @method Assignment setUri($value)
 * @method Assignment setType($value)
 * @method Assignment setPerson($value)
 * @method Assignment setActivity($value)
 * @method Assignment setSchedule($value)
 * @method Assignment setRoster($value)
 * @method Assignment setRosterFolder($value)
 *
 */
class Assignment extends Base {

    protected $attributes = [
        'id'           => 'id',
        'uri'          => 'uri',
        'type'         => 'type',
        'person'       => 'person',
        'activity'     => 'activity',
        'schedule'     => 'schedule',
        'roster'       => 'roster',
        'rosterFolder' => 'rosterFolder',
    ];

}