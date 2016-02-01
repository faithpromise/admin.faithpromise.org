<?php

namespace App\FaithPromise\FellowshipOne\Models\People;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class CommunicationType
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method CommunicationType setId($value)
 * @method CommunicationType setUri($value)
 * @method CommunicationType setName($value)
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