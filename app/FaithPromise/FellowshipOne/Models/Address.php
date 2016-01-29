<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class Address
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getHousehold()
 * @method string getPerson()
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
 * @method string setId($value)
 * @method string setUri($value)
 * @method string setHousehold($value)
 * @method string setPerson($value)
 * @method string setAddressType($value)
 * @method string setAddress1($value)
 * @method string setAddress2($value)
 * @method string setAddress3($value)
 * @method string setCity($value)
 * @method string setPostalCode($value)
 * @method string setCounty($value)
 * @method string setCountry($value)
 * @method string setStProvince($value)
 * @method string setCarrierRoute($value)
 * @method string setDeliveryPoint($value)
 * @method string setAddressDate($value)
 * @method string setAddressComment($value)
 * @method string setUspsVerified($value)
 * @method string setAddressVerifiedDate($value)
 * @method string setLastVerificationAttemptDate($value)
 * @method string setCreatedDate($value)
 * @method string setLastUpdatedDate($value)
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