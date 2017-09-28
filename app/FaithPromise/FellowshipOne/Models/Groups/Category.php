<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Category
 * @package App\FaithPromise\FellowshipOne\Models\Groups
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method Category setId($value)
 * @method Category setUri($value)
 * @method Category setName($value)
 *
 */

class Category extends Base {

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

}