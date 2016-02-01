<?php

namespace App\FaithPromise\FellowshipOne\Models\People;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Communication
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method Household getHousehold()
 * @method Person getPerson()
 * @method CommunicationType getCommunicationType()
 * @method string getCommunicationGeneralType()
 * @method string getCommunicationValue()
 * @method string getSearchCommunicationValue()
 * @method string getPreferred()
 * @method string getCommunicationComment()
 * @method string getCreatedDate()
 * @method string getLastUpdatedDate()
 *
 * @method Communication setId($value)
 * @method Communication setUri($value)
 * @method Communication setHousehold($value)
 * @method Communication setPerson($value)
 * @method Communication setCommunicationType($value)
 * @method Communication setCommunicationGeneralType($value)
 * @method Communication setCommunicationValue($value)
 * @method Communication setSearchCommunicationValue($value)
 * @method Communication setPreferred($value)
 * @method Communication setCommunicationComment($value)
 * @method Communication setCreatedDate($value)
 * @method Communication setLastUpdatedDate($value)
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