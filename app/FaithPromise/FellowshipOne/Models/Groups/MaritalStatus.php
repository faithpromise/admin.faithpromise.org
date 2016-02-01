<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class MaritalStatus
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method MaritalStatus setId($value)
 * @method MaritalStatus setUri($value)
 * @method MaritalStatus setName($value)
 *
 */

class MaritalStatus extends Base {

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