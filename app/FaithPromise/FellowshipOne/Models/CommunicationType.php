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

class CommunicationType extends Base {

    const HOME = 1;
    const WORK = 2;
    const MOBILE = 3;

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

    public function isHome() {
        return intval($this->getId()) === self::HOME;
    }

    public function isWork() {
        return intval($this->getId()) === self::WORK;
    }

    public function isMobile() {
        return intval($this->getId()) === self::MOBILE;
    }

}