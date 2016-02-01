<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class Campus
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method Campus setId($value)
 * @method Campus setUri($value)
 * @method Campus setName($value)
 *
 */

class Campus extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}