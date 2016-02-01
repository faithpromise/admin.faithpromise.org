<?php

namespace App\FaithPromise\FellowshipOne\Models\People;

use App\FaithPromise\FellowshipOne\Models\Base;
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
 * @method HouseholdMemberType getHouseholdMemberType()
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
 * @method Person setId($value)
 * @method Person setUri($value)
 * @method Person setImageURI($value)
 * @method Person setOldID($value)
 * @method Person setICode($value)
 * @method Person setHouseholdID($value)
 * @method Person setOldHouseholdID($value)
 * @method Person setTitle($value)
 * @method Person setSalutation($value)
 * @method Person setPrefix($value)
 * @method Person setFirstName($value)
 * @method Person setLastName($value)
 * @method Person setSuffix($value)
 * @method Person setMiddleName($value)
 * @method Person setGoesByName($value)
 * @method Person setFormerName($value)
 * @method Person setGender($value)
 * @method Person setDateOfBirth($value)
 * @method Person setMaritalStatus($value)
 * @method Person setHouseholdMemberType($value)
 * @method Person setIsAuthorized($value)
 * @method Person setStatus($value)
 * @method Person setOccupation($value)
 * @method Person setEmployer($value)
 * @method Person setSchool($value)
 * @method Person setDenomination($value)
 * @method Person setFormerChurch($value)
 * @method Person setBarCode($value)
 * @method Person setMemberEnvelopeCode($value)
 * @method Person setDefaultTagComment($value)
 * @method Person setWeblink($value)
 * @method Person setSolicit($value)
 * @method Person setThank($value)
 * @method Person setFirstRecord($value)
 * @method Person setAttributes($value)
 * @method Person setAddresses($value)
 * @method Person setCommunications($value)
 * @method Person setLastMatchDate($value)
 * @method Person setCreatedDate($value)
 * @method Person setLastUpdatedDate($value)
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
        'status'              => ['status', Status::class],
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

    public function getImage() {
        if (empty($this->getImageURI())) {
            return null;
        }

        return $this->getClient()->fetchImage($this->getImageURI());
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
            $this->setCommunications($this->getClient()->communications($this->getId())->all());
        }

        return $this->values['communications'];
    }

    public function getPrimaryAddress() {
        /** @noinspection PhpUnusedParameterInspection */
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
        /** @noinspection PhpUnusedParameterInspection */
        return $this->getCommunications()->first(function($key, Communication $communication) {
            return $communication->isPhone() && $communication->isPreferred();
        });
    }

    public function getMobilePhone() {
        /** @noinspection PhpUnusedParameterInspection */
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
        /** @noinspection PhpUnusedParameterInspection */
        return $this->getCommunications()->first(function($key, Communication $communication) {
            return $communication->isEmail() && $communication->isPreferred();
        });
    }

}