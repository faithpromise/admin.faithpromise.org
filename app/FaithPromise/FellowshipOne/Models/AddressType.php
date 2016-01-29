<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class AddressType
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

class AddressType extends Base {

    const PRIMARY = 1;

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

    public function isPrimary() {
        return intval($this->getId()) === self::PRIMARY;
    }

}