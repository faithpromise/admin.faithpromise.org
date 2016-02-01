<?php

namespace App\FaithPromise\FellowshipOne\Models;

use Illuminate\Support\Collection;

/**
 * Class Group
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getDescription()
 * @method string getStartDate()
 * @method string getExpirationDate()
 * @method string getIsOpen()
 * @method string getIsPublic()
 * @method string getHasChildcare()
 * @method string getIsSearchable()
 * @method string getChurchCampus()
 * @method string getGroupType()
 * @method string getGroupURL()
 * @method string getTimeZone()
 * @method string getGender()
 * @method string getMaritalStatus()
 * @method string getStartAgeRange()
 * @method string getEndAgeRange()
 * @method string getDateRangeType()
 * @method string getLeadersCount()
 * @method string getMembersCount()
 * @method string getOpenProspectsCount()
 * @method string getEvent()
 * @method string getLocation()
 * @method string getCreatedDate()
 * @method string getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method string getLastUpdatedByPerson()
 * @method string getIsLocationPrivate()
 *
 * @method string setId($value)
 * @method string setUri($value)
 * @method string setName($value)
 * @method string setDescription($value)
 * @method string setStartDate($value)
 * @method string setExpirationDate($value)
 * @method string setIsOpen($value)
 * @method string setIsPublic($value)
 * @method string setHasChildcare($value)
 * @method string setIsSearchable($value)
 * @method string setChurchCampus($value)
 * @method string setGroupType($value)
 * @method string setGroupURL($value)
 * @method string setTimeZone($value)
 * @method string setGender($value)
 * @method string setMaritalStatus($value)
 * @method string setStartAgeRange($value)
 * @method string setEndAgeRange($value)
 * @method string setDateRangeType($value)
 * @method string setLeadersCount($value)
 * @method string setMembersCount($value)
 * @method string setOpenProspectsCount($value)
 * @method string setEvent($value)
 * @method string setLocation($value)
 * @method string setCreatedDate($value)
 * @method string setCreatedByPerson($value)
 * @method string setLastUpdatedDate($value)
 * @method string setLastUpdatedByPerson($value)
 * @method string setIsLocationPrivate($value)
 *
 */
class Group extends Base {

    protected $attributes = [
        'id'                  => '@id',
        'uri'                 => '@uri',
        'name'                => 'name',
        'description'         => 'description',
        'startDate'           => 'startDate',
        'expirationDate'      => 'expirationDate',
        'isOpen'              => 'isOpen',
        'isPublic'            => 'isPublic',
        'hasChildcare'        => 'hasChildcare',
        'isSearchable'        => 'isSearchable',
        'churchCampus'        => 'churchCampus',
        'groupType'           => 'groupType',
        'groupURL'            => 'groupURL',
        'timeZone'            => 'timeZone',
        'gender'              => ['gender', GroupGender::class],
        'maritalStatus'       => ['maritalStatus', GroupMaritalStatus::class],
        'startAgeRange'       => 'startAgeRange',
        'endAgeRange'         => 'endAgeRange',
        'dateRangeType'       => 'dateRangeType',
        'leadersCount'        => 'leadersCount',
        'membersCount'        => 'membersCount',
        'openProspectsCount'  => 'openProspectsCount',
        'event'               => 'event',
        'location'            => 'location',
        'createdDate'         => 'createdDate',
        'createdByPerson'     => 'createdByPerson',
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => 'lastUpdatedByPerson',
        'isLocationPrivate'   => 'isLocationPrivate',
    ];

    public function getMembers($with_people = false) {
        $result = $this->getClient()->groupMembers($this->getId())->withPeople($with_people)->all();

        return $result->all();
    }

    public function getAverageAge() {

        $ages = [];

        /** @var GroupMember $member */
        foreach ($this->getMembers(true) as $member) {
            if ($member->getPerson()->hasDateOfBirth()) {
                $ages[] = $member->getPerson()->getAge();
            }
        }

        return count($ages) === 0 ? null : intval(round(array_sum($ages) / count($ages)));
    }

    public function getHouseHolds() {
        return $this->getClient()->households()->whereId($this->getUniqueHouseholdIds());
    }

    public function getChildAges() {

        $ages = new Collection();
        $households = $this->getHouseHolds();

        /** @var Household $household */
        foreach ($households as $household) {

            /** @var Person $person */
            foreach ($household->getChildren() as $person) {
                if ($person->hasDateOfBirth()) {
                    $ages->push($person->getAge());
                }
            }

        }

        return collect($ages)->sort()->values();

    }

    private function getUniqueHouseholdIds() {

        $members = $this->getMembers(true);
        $household_ids = new Collection();

        /** @var GroupMember $member */
        foreach ($members as $member) {
            $household_ids->put($member->getPerson()->getHouseholdId(), $member->getPerson()->getHouseholdId());
        }

        return $household_ids->values()->unique()->toArray();
    }

}