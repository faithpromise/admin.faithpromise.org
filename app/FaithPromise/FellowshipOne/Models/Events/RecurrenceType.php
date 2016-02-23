<?php

namespace App\FaithPromise\FellowshipOne\Models\Events;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Type
 * @package App\FaithPromise\FellowshipOne\Models\Events
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method RecurrenceType setId($value)
 * @method RecurrenceType setUri($value)
 * @method RecurrenceType setName($value)
 *
 */
class RecurrenceType extends Base {

    const DAILY = 1;
    const WEEKLY = 2;
    const MONTHLY = 3;
    const YEARLY = 4;

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

    public function isDaily() {
        return intval($this->getId()) === self::DAILY;
    }

    public function isWeekly() {
        return intval($this->getId()) === self::WEEKLY;
    }

    public function isMonthly() {
        return intval($this->getId()) === self::MONTHLY;
    }

    public function isYearly() {
        return intval($this->getId()) === self::YEARLY;
    }

}