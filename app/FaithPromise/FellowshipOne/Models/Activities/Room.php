<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Activity
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getCode()
 * @method string getDescription()
 *
 * @method Room setId($value)
 * @method Room setUri($value)
 * @method Room setName($value)
 * @method Room setCode($value)
 * @method Room setDescription($value)
 *
 */
class Room extends Base {

    protected $attributes = [
        'id'          => 'id',
        'uri'         => 'uri',
        'name'        => 'name',
        'code'        => 'code',
        'description' => 'description',
    ];

}