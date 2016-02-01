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
 * @method PersonSubStatus setId($value)
 * @method PersonSubStatus setUri($value)
 * @method PersonSubStatus setName($value)
 *
 */

class PersonSubStatus extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}