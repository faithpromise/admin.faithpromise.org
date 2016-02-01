<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class GroupDateRangeType
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method GroupDateRangeType setId($value)
 * @method GroupDateRangeType setUri($value)
 * @method GroupDateRangeType setName($value)
 *
 */

class GroupDateRangeType extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}