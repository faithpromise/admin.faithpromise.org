<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class HeadCount
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUrl()
 * @method string getActivity()
 * @method string getInstance()
 * @method string getRoster()
 * @method string getHeadCount()
 * @method string getActualMeetingDate()
 * @method string getMeetingNote()
 * @method string getCreatedDate()
 * @method string getLastUpdatedDate()
 *
 * @method HeadCount setId($value)
 * @method HeadCount setUrl($value)
 * @method HeadCount setActivity($value)
 * @method HeadCount setInstance($value)
 * @method HeadCount setRoster($value)
 * @method HeadCount setHeadCount($value)
 * @method HeadCount setActualMeetingDate($value)
 * @method HeadCount setMeetingNote($value)
 * @method HeadCount setCreatedDate($value)
 * @method HeadCount setLastUpdatedDate($value)
 *
 */
class HeadCount extends Base {

    protected $attributes = [
        'id'                => 'id',
        'url'               => 'url',
        'activity'          => 'activity',
        'instance'          => 'instance',
        'roster'            => 'roster',
        'headCount'         => 'headCount',
        'actualMeetingDate' => 'actualMeetingDate',
        'meetingNote'       => 'meetingNote',
        'createdDate'       => 'createdDate',
        'lastUpdatedDate'   => 'lastUpdatedDate',
    ];

}