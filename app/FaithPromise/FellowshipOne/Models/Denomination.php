<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class Denomination
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method Denomination setId($value)
 * @method Denomination setUri($value)
 * @method Denomination setName($value)
 *
 */

class Denomination extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}