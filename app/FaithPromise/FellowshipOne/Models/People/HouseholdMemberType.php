<?php

namespace App\FaithPromise\FellowshipOne\Models\People;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class HouseholdMemberType
 * @package App\FaithPromise\FellowshipOne\Models\People
 *
* @method string getId()
* @method string getUri()
* @method string getName()
 *
* @method HouseholdMemberType setId($value)
* @method HouseholdMemberType setUri($value)
* @method HouseholdMemberType setName($value)
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