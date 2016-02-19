<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Type
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method Type setId($value)
 * @method Type setUri($value)
 * @method Type setName($value)
 *
 */
class Type extends Base {

    protected $attributes = [
        'id'   => 'id',
        'uri'  => 'uri',
        'name' => 'name',
    ];

}