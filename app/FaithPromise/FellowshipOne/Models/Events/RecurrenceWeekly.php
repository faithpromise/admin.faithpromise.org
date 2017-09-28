<?php

namespace App\FaithPromise\FellowshipOne\Models\Events;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Type
 * @package App\FaithPromise\FellowshipOne\Models\Events
 *
 * @method string getRecurrenceFrequency()
 * @method string getOccurOnSunday()
 * @method string getOccurOnMonday()
 * @method string getOccurOnTuesday()
 * @method string getOccurOnWednesday()
 * @method string getOccurOnThursday()
 * @method string getOccurOnFriday()
 * @method string getOccurOnSaturday()
 *
 * @method RecurrenceWeekly setRecurrenceFrequency($value)
 * @method RecurrenceWeekly setOccurOnSunday($value)
 * @method RecurrenceWeekly setOccurOnMonday($value)
 * @method RecurrenceWeekly setOccurOnTuesday($value)
 * @method RecurrenceWeekly setOccurOnWednesday($value)
 * @method RecurrenceWeekly setOccurOnThursday($value)
 * @method RecurrenceWeekly setOccurOnFriday($value)
 * @method RecurrenceWeekly setOccurOnSaturday($value)
 *
 */
class RecurrenceWeekly extends Base {

    protected $booleans = ['occurOnSunday','occurOnMonday','occurOnTuesday','occurOnWednesday','occurOnThursday','occurOnFriday','occurOnSaturday'];

    protected $attributes = [
        'recurrenceFrequency' => 'recurrenceFrequency',
        'occurOnSunday'       => 'occurOnSunday',
        'occurOnMonday'       => 'occurOnMonday',
        'occurOnTuesday'      => 'occurOnTuesday',
        'occurOnWednesday'    => 'occurOnWednesday',
        'occurOnThursday'     => 'occurOnThursday',
        'occurOnFriday'       => 'occurOnFriday',
        'occurOnSaturday'     => 'occurOnSaturday',
    ];

    public function getByDay() {

        $days = [];

        if ($this->getOccurOnMonday()) {
            $days[] = 'MO';
        }
        if ($this->getOccurOnTuesday()) {
            $days[] = 'TU';
        }
        if ($this->getOccurOnWednesday()) {
            $days[] = 'WE';
        }
        if ($this->getOccurOnThursday()) {
            $days[] = 'TH';
        }
        if ($this->getOccurOnFriday()) {
            $days[] = 'FR';
        }
        if ($this->getOccurOnSaturday()) {
            $days[] = 'SA';
        }
        if ($this->getOccurOnSunday()) {
            $days[] = 'SU';
        }

        return $days;
    }

}