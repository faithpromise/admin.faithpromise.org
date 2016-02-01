<?php

namespace App\FaithPromise\FellowshipOne\Models\People;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Household
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getSortName()
 * @method string getFirstName()
 * @method string getLastActivityAt()
 * @method string getCreatedAt()
 * @method string getUpdatedAt()
 *
 * @method Household setId($value)
 * @method Household setUri($value)
 * @method Household setName($value)
 * @method Household setSortName($value)
 * @method Household setFirstName($value)
 * @method Household setLastActivityAt($value)
 * @method Household setCreatedAt($value)
 * @method Household setUpdatedAt($value)
 *
 */
class Household extends Base {

    protected $attributes = [
        'id'             => '@id',
        'uri'            => '@uri',
        'name'           => 'householdName',
        'sortName'       => 'householdSortName',
        'firstName'      => 'householdFirstName',
        'lastActivityAt' => 'lastActivityDate',
        'createdAt'      => 'createdDate',
        'updatedAt'      => 'lastUpdatedDate'
    ];

    public function getPeople() {
        return $this->getClient()->people()->byHousehold($this->getId());
    }

    public function getFamilyMembers() {
        return $this->getPeople()->filter(function(Person $person) {
            return $person->isFamilyMember();
        });
    }

    public function getAdults($include_non_family = false) {
        return $this->getPeople()->filter(function(Person $person) use ($include_non_family) {
            return ($person->isFamilyMember() || $include_non_family) && $person->isAdult();
        });
    }

    public function getChildren($include_non_family = false) {
        return $this->getPeople()->filter(function(Person $person) use ($include_non_family) {
            return ($person->isFamilyMember() || $include_non_family) && $person->isChild();
        });
    }

    public function getVisitors() {
        return $this->getPeople()->filter(function(Person $person) {
            return $person->isVisitor();
        });
    }

}
