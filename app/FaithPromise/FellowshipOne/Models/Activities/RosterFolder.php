<?php

namespace App\FaithPromise\FellowshipOne\Models\Activities;

use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class RosterFolder
 * @package App\FaithPromise\FellowshipOne\Models\Activities
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getActivity()
 *
 * @method Ministry setId($value)
 * @method Ministry setUri($value)
 * @method Ministry setName($value)
 * @method Ministry setActivity($value)
 *
 */
class RosterFolder extends Base {

    protected $attributes = [
        'id'       => 'id',
        'uri'      => 'uri',
        'name'     => 'name',
        'activity' => 'activity',
    ];

}