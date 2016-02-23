<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class TimeZone
 * @package App\FaithPromise\FellowshipOne\Models\Groups
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method TimeZone setId($value)
 * @method TimeZone setUri($value)
 * @method TimeZone setName($value)
 *
 */

class TimeZone extends Base {

    const ATLANTIC = 102; // (GMT-04:00) Atlantic Time (Canada)
    const CENTRAL = 115; // (GMT-06:00) Central Time (US & Canada)
    const EASTERN = 122; // (GMT-05:00) Eastern Time (US & Canada)
    const CONSTANT_NAME = 131; // (GMT-10:00) Hawaii
    const MOUNTAIN = 139; // (GMT-07:00) Mountain Time (US & Canada)
    const ALASKA = 147; // (GMT-09:00) Alaska
    const PACIFIC = 151; // (GMT-08:00) Pacific Time (US & Canada); Tijuana
    const ARIZONA = 167; // (GMT-07:00) Arizona

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];



}