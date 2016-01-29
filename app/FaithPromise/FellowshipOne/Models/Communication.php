<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class Communication
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getHousehold()
 * @method string getPerson()
 * @method CommunicationType getCommunicationType()
 * @method string getCommunicationGeneralType()
 * @method string getCommunicationValue()
 * @method string getSearchCommunicationValue()
 * @method string getPreferred()
 * @method string getCommunicationComment()
 * @method string getCreatedDate()
 * @method string getLastUpdatedDate()
 *
 * @method string setId($value)
 * @method string setUri($value)
 * @method string setHousehold($value)
 * @method string setPerson($value)
 * @method string setCommunicationType($value)
 * @method string setCommunicationGeneralType($value)
 * @method string setCommunicationValue($value)
 * @method string setSearchCommunicationValue($value)
 * @method string setPreferred($value)
 * @method string setCommunicationComment($value)
 * @method string setCreatedDate($value)
 * @method string setLastUpdatedDate($value)
 *
 */

class Communication extends Base {

    protected $attributes = [
        'id'                       => '@id',
        'uri'                      => '@uri',
        'household'                => ['household', Household::class],
        'person'                   => ['person', Person::class],
        'communicationType'        => ['communicationType', CommunicationType::class],
        'communicationGeneralType' => 'communicationGeneralType',
        'communicationValue'       => 'communicationValue',
        'searchCommunicationValue' => 'searchCommunicationValue',
        'preferred'                => 'preferred',
        'communicationComment'     => 'communicationComment',
        'createdDate'              => 'createdDate',
        'lastUpdatedDate'          => 'lastUpdatedDate',
    ];

    public function isPhone() {
        return strcasecmp($this->getCommunicationGeneralType(), 'Telephone') === 0;
    }

    public function isMobilePhone() {
        return strcasecmp($this->getCommunicationGeneralType(), 'Telephone') === 0 && $this->getCommunicationType()->isMobile();
    }

    public function isEmail() {
        return strcasecmp($this->getCommunicationGeneralType(), 'Email') === 0;
    }

    public function isPreferred() {
        return strcasecmp($this->getPreferred(), 'true') === 0;
    }

}