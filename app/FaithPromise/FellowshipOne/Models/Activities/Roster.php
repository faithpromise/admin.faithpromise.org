<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Roster
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getActivity()
 * @method string getRosterFolder()
 * @method string getRoom()
 * @method string getCheckinAutoOpen()
 * @method string getCheckinEnabled()
 * @method string getHasNameTag()
 * @method string getHasReceipt()
 * @method string getDefaultCapacity()
 * @method string getStartAgeDate()
 * @method string getEndAgeDate()
 * @method string getStartAgeRange()
 * @method string getEndAgeRange()
 * @method string getAgeRangeType()
 * @method string getDefaultAge()
 * @method string getScheduleID()
 * @method string getPagerEnabled()
 * @method string getIsClosed()
 *
 * @method Roster setId($value)
 * @method Roster setUri($value)
 * @method Roster setName($value)
 * @method Roster setActivity($value)
 * @method Roster setRosterFolder($value)
 * @method Roster setRoom($value)
 * @method Roster setCheckinAutoOpen($value)
 * @method Roster setCheckinEnabled($value)
 * @method Roster setHasNameTag($value)
 * @method Roster setHasReceipt($value)
 * @method Roster setDefaultCapacity($value)
 * @method Roster setStartAgeDate($value)
 * @method Roster setEndAgeDate($value)
 * @method Roster setStartAgeRange($value)
 * @method Roster setEndAgeRange($value)
 * @method Roster setAgeRangeType($value)
 * @method Roster setDefaultAge($value)
 * @method Roster setScheduleID($value)
 * @method Roster setPagerEnabled($value)
 * @method Roster setIsClosed($value)
 *
 */
class Roster extends Base {

    protected $attributes = [
        'id'              => 'id',
        'uri'             => 'uri',
        'name'            => 'name',
        'activity'        => 'activity',
        'rosterFolder'    => 'rosterFolder',
        'room'            => 'room',
        'checkinAutoOpen' => 'checkinAutoOpen',
        'checkinEnabled'  => 'checkinEnabled',
        'hasNameTag'      => 'hasNameTag',
        'hasReceipt'      => 'hasReceipt',
        'defaultCapacity' => 'defaultCapacity',
        'startAgeDate'    => 'startAgeDate',
        'endAgeDate'      => 'endAgeDate',
        'startAgeRange'   => 'startAgeRange',
        'endAgeRange'     => 'endAgeRange',
        'ageRangeType'    => 'ageRangeType',
        'defaultAge'      => 'defaultAge',
        'scheduleID'      => 'scheduleID',
        'pagerEnabled'    => 'pagerEnabled',
        'isClosed'        => 'isClosed',
    ];

}