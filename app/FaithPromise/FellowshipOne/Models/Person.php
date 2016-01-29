<?php

namespace App\FaithPromise\FellowshipOne\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class Person
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getImageURI()
 * @method string getOldID()
 * @method string getICode()
 * @method string getHouseholdID()
 * @method string getOldHouseholdID()
 * @method string getTitle()
 * @method string getSalutation()
 * @method string getPrefix()
 * @method string getFirstName()
 * @method string getLastName()
 * @method string getSuffix()
 * @method string getMiddleName()
 * @method string getGoesByName()
 * @method string getFormerName()
 * @method string getGender()
 * @method string getDateOfBirth()
 * @method string getMaritalStatus()
 * @method string getHouseholdMemberType()
 * @method string getIsAuthorized()
 * @method string getStatus()
 * @method string getOccupation()
 * @method string getEmployer()
 * @method string getSchool()
 * @method string getDenomination()
 * @method string getFormerChurch()
 * @method string getBarCode()
 * @method string getMemberEnvelopeCode()
 * @method string getDefaultTagComment()
 * @method string getWeblink()
 * @method string getSolicit()
 * @method string getThank()
 * @method string getFirstRecord()
 * @method string getAttributes()
 * @method string getLastMatchDate()
 * @method string getCreatedDate()
 * @method string getLastUpdatedDate()
 *
 * @method string setId($value)
 * @method string setUri($value)
 * @method string setImageURI($value)
 * @method string setOldID($value)
 * @method string setICode($value)
 * @method string setHouseholdID($value)
 * @method string setOldHouseholdID($value)
 * @method string setTitle($value)
 * @method string setSalutation($value)
 * @method string setPrefix($value)
 * @method string setFirstName($value)
 * @method string setLastName($value)
 * @method string setSuffix($value)
 * @method string setMiddleName($value)
 * @method string setGoesByName($value)
 * @method string setFormerName($value)
 * @method string setGender($value)
 * @method string setDateOfBirth($value)
 * @method string setMaritalStatus($value)
 * @method string setHouseholdMemberType($value)
 * @method string setIsAuthorized($value)
 * @method string setStatus($value)
 * @method string setOccupation($value)
 * @method string setEmployer($value)
 * @method string setSchool($value)
 * @method string setDenomination($value)
 * @method string setFormerChurch($value)
 * @method string setBarCode($value)
 * @method string setMemberEnvelopeCode($value)
 * @method string setDefaultTagComment($value)
 * @method string setWeblink($value)
 * @method string setSolicit($value)
 * @method string setThank($value)
 * @method string setFirstRecord($value)
 * @method string setAttributes($value)
 * @method string setAddresses($value)
 * @method string setCommunications($value)
 * @method string setLastMatchDate($value)
 * @method string setCreatedDate($value)
 * @method string setLastUpdatedDate($value)
 *
 */
class Person extends Base {

    protected $attributes = [
        'id'                  => '@id',
        'uri'                 => '@uri',
        'imageURI'            => '@imageURI',
        'oldID'               => '@oldID',
        'iCode'               => '@iCode',
        'householdID'         => '@householdID',
        'oldHouseholdID'      => '@oldHouseholdID',
        'title'               => 'title',
        'salutation'          => 'salutation',
        'prefix'              => 'prefix',
        'firstName'           => 'firstName',
        'lastName'            => 'lastName',
        'suffix'              => 'suffix',
        'middleName'          => 'middleName',
        'goesByName'          => 'goesByName',
        'formerName'          => 'formerName',
        'gender'              => 'gender',
        'dateOfBirth'         => 'dateOfBirth',
        'maritalStatus'       => 'maritalStatus',
        'householdMemberType' => ['householdMemberType', HouseholdMemberType::class],
        'isAuthorized'        => 'isAuthorized',
        'status'              => ['status', PersonStatus::class],
        'occupation'          => ['occupation', Occupation::class],
        'employer'            => 'employer',
        'school'              => ['school', School::class],
        'denomination'        => ['denomination', Denomination::class],
        'formerChurch'        => 'formerChurch',
        'barCode'             => 'barCode',
        'memberEnvelopeCode'  => 'memberEnvelopeCode',
        'defaultTagComment'   => 'defaultTagComment',
        'weblink'             => 'weblink',
        'solicit'             => 'solicit',
        'thank'               => 'thank',
        'firstRecord'         => 'firstRecord',
        'attributes'          => 'attributes',
        'addresses'           => ['addresses', Address::class],
        'communications'      => ['communications', Communication::class],
        'lastMatchDate'       => 'lastMatchDate',
        'createdDate'         => 'createdDate',
        'lastUpdatedDate'     => 'lastUpdatedDate',
    ];

//    public function getGroups() {
//        return $this->getClient()->groupMembers()->wherePersonId($this->getId());
//    }

    public function getName() {
        return array_key_exists('name', $this->values) ? $this->values['name'] : trim($this->getFirstName() . ' ' . $this->getLastName());
    }

    public function getFullName() {
        return preg_replace('/\s\s+/', ' ', $this->getFirstName() . ' ' . $this->getMiddleName() . ' ' . $this->getLastName());
    }

    public function getAge() {
        $dob = Carbon::parse($this->getDateOfBirth());

        return $dob ? $dob->age : null;
    }

    public function isAdult() {
        return $this->getAge() >= 18 || $this->getHouseholdMemberType()->isHead() || $this->getHouseholdMemberType()->isSpouse();
    }

    public function isChild() {
        return $this->getAge() < 18 || (!$this->hasDateOfBirth() && $this->getHouseholdMemberType()->isChild());
    }

    public function isVisitor() {
        return $this->getHouseholdMemberType()->isVisitor();
    }

    public function isFamilyMember() {
        return $this->getHouseholdMemberType()->isFamilyMember();
    }

    public function hasDateOfBirth() {
        return !empty($this->getDateOfBirth());
    }

    /**
     * @return Collection
     */
    public function getAddresses() {
        // Make sure addresses are loaded
        if (!$this->values['addresses']) {
            // TODO: add @methods for set methods
            $this->setAddresses($this->getClient()->addresses($this->getId())->all());
        }

        return $this->values['addresses'];
    }

    /**
     * @return Collection
     */
    public function getCommunications() {
        // Make sure communications are loaded
        if (!$this->values['communications']) {
            // TODO: add @methods for set methods
            $this->setCommunications($this->getClient()->communications($this->getId())->all());
        }

        return $this->values['communications'];
    }

    public function getPrimaryAddress() {
        return $this->getAddresses()->first(function($key, Address $address) {
            return $address->getAddressType()->isPrimary();
        });
    }

    public function getPhones() {
        return $this->getCommunications()->filter(function(Communication $communication) {
            return $communication->isPhone();
        });
    }

    public function getPreferredPhone() {
        return $this->getCommunications()->first(function($key, Communication $communication) {
            return $communication->isPhone() && $communication->isPreferred();
        });
    }

    public function getMobilePhone() {
        return $this->getCommunications()->first(function($key, Communication $communication) {
            return $communication->isMobilePhone();
        });
    }

    public function getEmails() {
        return $this->getCommunications()->filter(function(Communication $communication) {
            return $communication->isEmail();
        });
    }

    public function getPreferredEmail() {
        return $this->getCommunications()->first(function($key, Communication $communication) {
            return $communication->isEmail() && $communication->isPreferred();
        });
    }

}