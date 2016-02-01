<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class GroupType
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method GroupType setId($value)
 * @method GroupType setUri($value)
 * @method GroupType setName($value)
 *
 */

class GroupType extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}