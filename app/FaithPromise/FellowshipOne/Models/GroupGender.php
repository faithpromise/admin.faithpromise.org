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
 * @method GroupGender setId($value)
 * @method GroupGender setUri($value)
 * @method GroupGender setName($value)
 *
 */

class GroupGender extends Base {

    const COED = 0;
    const MALE = 1;
    const FEMALE = 2;

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

    public function isMenOnly() {
        return intval($this->getId()) === self::MALE;
    }

    public function isFemaleOnly() {
        return intval($this->getId()) === self::FEMALE;
    }

    public function isCoed() {
        return intval($this->getId()) === self::COED;
    }

}