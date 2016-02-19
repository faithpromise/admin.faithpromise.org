<?php

namespace App\FaithPromise\FellowshipOne\Models\People;
use App\FaithPromise\FellowshipOne\Models\Base;

/**
 * Class Status
 * @package App\FaithPromise\FellowshipOne\Models\People
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getComment()
 * @method string getDate()
 * @method string getSubStatus()
 *
 * @method Status setId($value)
 * @method Status setUri($value)
 * @method Status setName($value)
 * @method Status setComment($value)
 * @method Status setSubStatus($value)
 *
 */

class Status extends Base {

    protected $attributes = [
        'id'        => '@id',
        'uri'       => '@uri',
        'name'      => 'name',
        'comment'   => 'comment',
        'date'      => 'date',
        'subStatus' => ['subStatus', SubStatus::class],
    ];

}