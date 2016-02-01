<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Gender
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method Gender setId($value)
 * @method Gender setUri($value)
 * @method Gender setName($value)
 *
 */

class Gender extends Base {

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