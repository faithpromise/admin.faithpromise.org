<?php

namespace App\FaithPromise\FellowshipOne\Models\Events;

use App\FaithPromise\FellowshipOne\Models\Base;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Recurr\Rule;

/**
 * Class Schedule
 * @package App\FaithPromise\FellowshipOne\Models\Events
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getDescription()
 * @method Carbon getStartTime()
 * @method Carbon getEndTime()
 * @method string getNumberRecurrences()
 * @method Carbon getStartDate()
 * @method Carbon getEndDate()
 * @method RecurrenceType getRecurrenceType()
 * @method Collection getRecurrences()
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

    protected $dates = ['startDate', 'endDate', 'startTime', 'endTime'];

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
        'recurrenceType'      => ['recurrenceType', RecurrenceType::class],
        'recurrences'         => ['recurrences', Recurrence::class, true],
        'createdDate'         => 'createdDate',
        'createdByPerson'     => 'createdByPerson',
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => 'lastUpdatedByPerson',
    ];

    public function getRecurrenceRule() {

        $rule = new Rule();
        $rule->setFreq(strtoupper($this->getRecurrenceType()->getName()));
        $rule->setInterval($this->getFrequency());
        $rule->setStartDate($this->getStartDate());
        $rule->setEndDate($this->getEndDate());
        $rule->setByDay($this->getByDay());

        return $rule->getString();
    }

    private function getFrequency() {

        if ($this->getRecurrenceType()->isWeekly()) {
            return intval($this->getRecurrences()->first()->getRecurrenceWeekly()->getRecurrenceFrequency());
        }

        // Otherwise, monthly
        return intval($this->getRecurrences()->first()->getRecurrenceMonthly()->getRecurrenceFrequency());
    }

    private function getByDay() {

        if ($this->getRecurrenceType()->isWeekly()) {
            $days = $this->getRecurrences()->first()->getRecurrenceWeekly()->getByDay();
        } else {
            $days = [];

            /** @var Recurrence $recurrence */
            foreach($this->getRecurrences() as $recurrence) {
                $days[] = $recurrence->getRecurrenceMonthly()->getRecurrenceOffset() . strtoupper(substr($recurrence->getRecurrenceMonthly()->getMonthWeekDayName(), 0, 2));
            }
        }

        return $days;
    }

}