<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class PersonSubStatus
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method string setId($value)
 * @method string setUri($value)
 * @method string setName($value)
 *
 */

class PersonSubStatus extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}