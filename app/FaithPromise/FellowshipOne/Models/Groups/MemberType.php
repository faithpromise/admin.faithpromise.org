<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class MemberType
 * @package App\FaithPromise\FellowshipOne\Models\Groups
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 *
 * @method TimeZone setId($value)
 * @method TimeZone setUri($value)
 * @method TimeZone setName($value)
 *
 */

class MemberType extends Base {

    const LEADER = 1;
    const MEMBER = 2;

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

    public function isLeader() {
        return intval($this->getId()) === self::LEADER;
    }

}