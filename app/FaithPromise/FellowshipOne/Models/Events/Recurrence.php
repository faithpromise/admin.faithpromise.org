<?php

namespace App\FaithPromise\FellowshipOne\Models\Events;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Type
 * @package App\FaithPromise\FellowshipOne\Models\Events
 *
 * @method RecurrenceWeekly getRecurrenceWeekly()
 * @method RecurrenceMonthly getRecurrenceMonthly()
 *
 * @method Recurrence setRecurrenceWeekly($value)
 * @method Recurrence setRecurrenceMonthly($value)
 *
 */
class Recurrence extends Base {

    protected $attributes = [
        'recurrenceWeekly'  => ['recurrenceWeekly', RecurrenceWeekly::class],
        'recurrenceMonthly' => ['recurrenceMonthly', RecurrenceMonthly::class],
    ];

}