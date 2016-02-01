<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class Address
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method Household getHousehold()
 * @method Person getPerson()
 * @method AddressType getAddressType()
 * @method string getAddress1()
 * @method string getAddress2()
 * @method string getAddress3()
 * @method string getCity()
 * @method string getPostalCode()
 * @method string getCounty()
 * @method string getCountry()
 * @method string getStProvince()
 * @method string getCarrierRoute()
 * @method string getDeliveryPoint()
 * @method string getAddressDate()
 * @method string getAddressComment()
 * @method string getUspsVerified()
 * @method string getAddressVerifiedDate()
 * @method string getLastVerificationAttemptDate()
 * @method string getCreatedDate()
 * @method string getLastUpdatedDate()
 *
 * @method Address setId($value)
 * @method Address setUri($value)
 * @method Address setHousehold($value)
 * @method Address setPerson($value)
 * @method Address setAddressType($value)
 * @method Address setAddress1($value)
 * @method Address setAddress2($value)
 * @method Address setAddress3($value)
 * @method Address setCity($value)
 * @method Address setPostalCode($value)
 * @method Address setCounty($value)
 * @method Address setCountry($value)
 * @method Address setStProvince($value)
 * @method Address setCarrierRoute($value)
 * @method Address setDeliveryPoint($value)
 * @method Address setAddressDate($value)
 * @method Address setAddressComment($value)
 * @method Address setUspsVerified($value)
 * @method Address setAddressVerifiedDate($value)
 * @method Address setLastVerificationAttemptDate($value)
 * @method Address setCreatedDate($value)
 * @method Address setLastUpdatedDate($value)
 *
 */

class Address extends Base {

    protected $attributes = [
        'id'                          => '@id',
        'uri'                         => '@uri',
        'household'                   => ['household', Household::class],
        'person'                      => ['person', Person::class],
        'addressType'                 => ['addressType', AddressType::class],
        'address1'                    => 'address1',
        'address2'                    => 'address2',
        'address3'                    => 'address3',
        'city'                        => 'city',
        'postalCode'                  => 'postalCode',
        'county'                      => 'county',
        'country'                     => 'country',
        'stProvince'                  => 'stProvince',
        'carrierRoute'                => 'carrierRoute',
        'deliveryPoint'               => 'deliveryPoint',
        'addressDate'                 => 'addressDate',
        'addressComment'              => 'addressComment',
        'uspsVerified'                => 'uspsVerified',
        'addressVerifiedDate'         => 'addressVerifiedDate',
        'lastVerificationAttemptDate' => 'lastVerificationAttemptDate',
        'createdDate'                 => 'createdDate',
        'lastUpdatedDate'             => 'lastUpdatedDate',
    ];

}