<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class HouseholdMemberType
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

class HouseholdMemberType extends Base {

    const HEAD = 1;
    const SPOUSE = 2;
    const CHILD = 3;
    const OTHER = 4;
    const VISITOR = 101;

    private $family_types = [self::HEAD, self::SPOUSE, self::CHILD];

    protected $attributes = [
        'id'   => '@id',
        'uri'  => '@uri',
        'name' => 'name',
    ];

    public function isFamilyMember() {
        return in_array($this->getId(), $this->family_types);
    }

    public function isHead() {
        return intval($this->getId()) === self::HEAD;
    }

    public function isSpouse() {
        return intval($this->getId()) === self::SPOUSE;
    }

    public function isChild() {
        return intval($this->getId()) === self::CHILD;
    }

    public function isVisitor() {
        return intval($this->getId()) === self::VISITOR;
    }

}