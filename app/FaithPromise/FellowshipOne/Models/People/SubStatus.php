<?php

namespace App\FaithPromise\FellowshipOne\Models\People;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class SubStatus
 * @package App\FaithPromise\FellowshipOne\Models\People
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method SubStatus setId($value)
 * @method SubStatus setUri($value)
 * @method SubStatus setName($value)
 *
 */

class SubStatus extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}