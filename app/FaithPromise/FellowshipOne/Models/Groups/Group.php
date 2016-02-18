<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;

use App\FaithPromise\FellowshipOne\Models\Base;
use App\FaithPromise\FellowshipOne\Models\People\Person;
use Illuminate\Support\Collection;

/**
 * Class Group
 * @package App\FaithPromise\FellowshipOne\Models\Groups
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
 * @method Campus getChurchCampus()
 * @method Type getGroupType()
 * @method string getGroupURL()
 * @method TimeZone getTimeZone()
 * @method Gender getGender()
 * @method MaritalStatus getMaritalStatus()
 * @method string getStartAgeRange()
 * @method string getEndAgeRange()
 * @method DateRangeType getDateRangeType()
 * @method string getLeadersCount()
 * @method string getMembersCount()
 * @method string getOpenProspectsCount()
 * @method string getEvent()
 * @method Location getLocation()
 * @method string getCreatedDate()
 * @method Person getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method Person getLastUpdatedByPerson()
 * @method string getIsLocationPrivate()
 *
 * @method Group setId($value)
 * @method Group setUri($value)
 * @method Group setName($value)
 * @method Group setDescription($value)
 * @method Group setStartDate($value)
 * @method Group setExpirationDate($value)
 * @method Group setIsOpen($value)
 * @method Group setIsPublic($value)
 * @method Group setHasChildcare($value)
 * @method Group setIsSearchable($value)
 * @method Group setChurchCampus($value)
 * @method Group setGroupType($value)
 * @method Group setGroupURL($value)
 * @method Group setTimeZone($value)
 * @method Group setGender($value)
 * @method Group setMaritalStatus($value)
 * @method Group setStartAgeRange($value)
 * @method Group setEndAgeRange($value)
 * @method Group setDateRangeType($value)
 * @method Group setLeadersCount($value)
 * @method Group setMembersCount($value)
 * @method Group setOpenProspectsCount($value)
 * @method Group setEvent($value)
 * @method Group setLocation($value)
 * @method Group setCreatedDate($value)
 * @method Group setCreatedByPerson($value)
 * @method Group setLastUpdatedDate($value)
 * @method Group setLastUpdatedByPerson($value)
 * @method Group setIsLocationPrivate($value)
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
        'churchCampus'        => ['churchCampus', Campus::class],
        'groupType'           => ['groupType', Type::class],
        'groupURL'            => 'groupURL',
        'timeZone'            => ['timeZone', TimeZone::class],
        'gender'              => ['gender', Gender::class],
        'maritalStatus'       => ['maritalStatus', MaritalStatus::class],
        'startAgeRange'       => 'startAgeRange',
        'endAgeRange'         => 'endAgeRange',
        'dateRangeType'       => ['dateRangeType', DateRangeType::class],
        'leadersCount'        => 'leadersCount',
        'membersCount'        => 'membersCount',
        'openProspectsCount'  => 'openProspectsCount',
        'event'               => 'event',
        'location'            => ['location', Location::class],
        'createdDate'         => 'createdDate',
        'createdByPerson'     => ['createdByPerson', Person::class],
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => ['lastUpdatedByPerson', Person::class],
        'isLocationPrivate'   => 'isLocationPrivate',
    ];

    public function getMembers($with_people = false) {
        $result = $this->getClient()->groupMembers($this->getId())->withPeople($with_people)->all();

        return $result;
    }

    public function getLeaders($with_people = false) {
        return $this->getMembers($with_people)->filter(function(Member $member) {
            return $member->isLeader();
        });
    }

    public function getAverageAge() {

        $ages = [];

        /** @var Member $member */
        foreach ($this->getMembers(true) as $member) {
            if ($member->getPerson()->hasDateOfBirth()) {
                $ages[] = $member->getPerson()->getAge();
            }
        }

        return count($ages) === 0 ? null : intval(round(array_sum($ages) / count($ages)));
    }

    public function getHouseHolds() {
        return $this->getClient()->households()->byId($this->getUniqueHouseholdIds());
    }

    public function getChildAges() {

        $ages = new Collection();
        $households = $this->getHouseHolds();

        /** @var \App\FaithPromise\FellowshipOne\Models\People\Household $household */
        foreach ($households as $household) {

            /** @var \App\FaithPromise\FellowshipOne\Models\People\Person $person */
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

        /** @var Member $member */
        foreach ($members as $member) {
            $household_ids->put($member->getPerson()->getHouseholdId(), $member->getPerson()->getHouseholdId());
        }

        return $household_ids->values()->unique()->toArray();
    }

}