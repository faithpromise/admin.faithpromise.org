<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Attendance
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUrl()
 * @method string getPerson()
 * @method string getActivity()
 * @method string getInstance()
 * @method string getRoster()
 * @method string getType()
 * @method string getCheckin()
 * @method string getCheckout()
 * @method string getCreatedDate()
 * @method string getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method string getLastUpdatedByPerson()
 *
 * @method Attendance setId($value)
 * @method Attendance setUrl($value)
 * @method Attendance setPerson($value)
 * @method Attendance setActivity($value)
 * @method Attendance setInstance($value)
 * @method Attendance setRoster($value)
 * @method Attendance setType($value)
 * @method Attendance setCheckin($value)
 * @method Attendance setCheckout($value)
 * @method Attendance setCreatedDate($value)
 * @method Attendance setCreatedByPerson($value)
 * @method Attendance setLastUpdatedDate($value)
 * @method Attendance setLastUpdatedByPerson($value)
 *
 */
class Attendance extends Base {

    protected $attributes = [
        'id'                  => 'id',
        'url'                 => 'url',
        'person'              => 'person',
        'activity'            => 'activity',
        'instance'            => 'instance',
        'roster'              => 'roster',
        'type'                => 'type',
        'checkin'             => 'checkin',
        'checkout'            => 'checkout',
        'createdDate'         => 'createdDate',
        'createdByPerson'     => 'createdByPerson',
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => 'lastUpdatedByPerson',
    ];

}