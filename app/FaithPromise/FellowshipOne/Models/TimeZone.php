<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class TimeZone
 * @package App\FaithPromise\FellowshipOne\Models
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

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}