<?php

namespace App\FaithPromise\FellowshipOne\Models\Events;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Type
 * @package App\FaithPromise\FellowshipOne\Models\Events
 *
 * @method string getRecurrenceFrequency()
 * @method string getMonthDay()
 * @method string getMonthWeekDay()
 *
 * @method RecurrenceMonthly setRecurrenceFrequency($value)
 * @method RecurrenceMonthly setRecurrenceOffset($value)
 * @method RecurrenceMonthly setMonthDay($value)
 * @method RecurrenceMonthly setMonthWeekDay($value)
 *
 */
class RecurrenceMonthly extends Base {

    protected $attributes = [
        'recurrenceFrequency' => 'recurrenceFrequency',
        'recurrenceOffset'    => 'recurrenceOffset',
        'monthDay'            => 'monthDay',
        'monthWeekDay'        => 'monthWeekDay',
    ];

    private static $weekDayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    public function getRecurrenceOffset() {
        return intval($this->values['recurrenceoffset']) === 6 ? -1 : intval($this->values['recurrenceoffset']);
    }

    public function getMonthWeekDayName() {
        return self::$weekDayNames[$this->getMonthWeekDay() - 1];
    }

}