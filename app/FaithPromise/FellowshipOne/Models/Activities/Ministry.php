<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Ministry
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method Ministry setId($value)
 * @method Ministry setUri($value)
 * @method Ministry setName($value)
 *
 */

class Ministry extends Base {

    protected $attributes = [
        'id'   => 'id',
        'uri'  => 'uri',
        'name' => 'name',
    ];

}