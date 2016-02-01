<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class CommunicationType
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

class GroupMaritalStatus extends Base {

    const MARRIED_OR_SINGLE = 0;
    const MARRIED = 1;
    const SINGLE = 2;

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

    public function isMarriedOnly() {
        return intval($this->getId()) === self::MARRIED;
    }

    public function isSinglesOnly() {
        return intval($this->getId()) === self::SINGLE;
    }

    public function isMarriedAndSingle() {
        return intval($this->getId()) === self::MARRIED_OR_SINGLE;
    }

}