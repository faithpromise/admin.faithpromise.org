<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class DateRangeType
 * @package App\FaithPromise\FellowshipOne\Models\Groups
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method DateRangeType setId($value)
 * @method DateRangeType setUri($value)
 * @method DateRangeType setName($value)
 *
 */

class DateRangeType extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}