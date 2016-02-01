<?php

namespace App\FaithPromise\FellowshipOne\Models\Groups;

use App\FaithPromise\FellowshipOne\Models\Base;
use App\FaithPromise\FellowshipOne\Models\People\Person;

/**
 * Class Address
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getAddress1()
 * @method string getAddress2()
 * @method string getAddress3()
 * @method string getCity()
 * @method string getStProvince()
 * @method string getPostalCode()
 * @method string getCounty()
 * @method string getCountry()
 * @method string getCarrierRoute()
 * @method string getDeliveryPoint()
 * @method string getLatitude()
 * @method string getLongitude()
 * @method string getCreatedDate()
 * @method Person getCreatedByPerson()
 * @method string getLastUpdatedDate()
 * @method Person getLastUpdatedByPerson()
 *
 * @method Address setAddress1($value)
 * @method Address setAddress2($value)
 * @method Address setAddress3($value)
 * @method Address setCity($value)
 * @method Address setStProvince($value)
 * @method Address setPostalCode($value)
 * @method Address setCounty($value)
 * @method Address setCountry($value)
 * @method Address setCarrierRoute($value)
 * @method Address setDeliveryPoint($value)
 * @method Address setLatitude($value)
 * @method Address setLongitude($value)
 * @method Address setCreatedDate($value)
 * @method Address setCreatedByPerson($value)
 * @method Address setLastUpdatedDate($value)
 * @method Address setLastUpdatedByPerson($value)
 *
 */
class Address extends Base {

    protected $attributes = [
        'address1'            => 'address1',
        'address2'            => 'address2',
        'address3'            => 'address3',
        'city'                => 'city',
        'stProvince'          => 'stProvince',
        'postalCode'          => 'postalCode',
        'county'              => 'county',
        'country'             => 'country',
        'carrierRoute'        => 'carrierRoute',
        'deliveryPoint'       => 'deliveryPoint',
        'latitude'            => 'latitude',
        'longitude'           => 'longitude',
        'createdDate'         => 'createdDate',
        'createdByPerson'     => 'createdByPerson',
        'lastUpdatedDate'     => 'lastUpdatedDate',
        'lastUpdatedByPerson' => 'lastUpdatedByPerson',
    ];

}