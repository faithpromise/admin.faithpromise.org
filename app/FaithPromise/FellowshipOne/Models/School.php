<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class School
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method School setId($value)
 * @method School setUri($value)
 * @method School setName($value)
 *
 */

class School extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}