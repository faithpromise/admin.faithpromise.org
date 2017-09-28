<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Activity
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getDescription()
 * @method string getHasCheckin()
 * @method string getCheckinMinutesBefore()
 * @method string getHasNameTag()
 * @method string getHasReceipt()
 * @method string getStartAge()
 * @method string getEndAge()
 * @method string getConfidential()
 * @method string getRequiresRegistration()
 * @method string getRosterBySchedule()
 * @method string getAssignmentsOverrideClosedRoom()
 * @method string getAutoAssignmentOption()
 * @method string getPagerEnabled()
 * @method string getWebEnabled()
 *
 * @method Activity setId($value)
 * @method Activity setUri($value)
 * @method Activity setName($value)
 * @method Activity setDescription($value)
 * @method Activity setHasCheckin($value)
 * @method Activity setCheckinMinutesBefore($value)
 * @method Activity setHasNameTag($value)
 * @method Activity setHasReceipt($value)
 * @method Activity setStartAge($value)
 * @method Activity setEndAge($value)
 * @method Activity setConfidential($value)
 * @method Activity setRequiresRegistration($value)
 * @method Activity setRosterBySchedule($value)
 * @method Activity setAssignmentsOverrideClosedRoom($value)
 * @method Activity setAutoAssignmentOption($value)
 * @method Activity setPagerEnabled($value)
 * @method Activity setWebEnabled($value)
 *
 */
class Activity extends Base {

    protected $attributes = [
        'id'                            => 'id',
        'uri'                           => 'uri',
        'name'                          => 'name',
        'description'                   => 'description',
        'hasCheckin'                    => 'hasCheckin',
        'checkinMinutesBefore'          => 'checkinMinutesBefore',
        'hasNameTag'                    => 'hasNameTag',
        'hasReceipt'                    => 'hasReceipt',
        'startAge'                      => 'startAge',
        'endAge'                        => 'endAge',
        'confidential'                  => 'confidential',
        'requiresRegistration'          => 'requiresRegistration',
        'rosterBySchedule'              => 'rosterBySchedule',
        'assignmentsOverrideClosedRoom' => 'assignmentsOverrideClosedRoom',
        'autoAssignmentOption'          => 'autoAssignmentOption',
        'pagerEnabled'                  => 'pagerEnabled',
        'webEnabled'                    => 'webEnabled',
    ];

}