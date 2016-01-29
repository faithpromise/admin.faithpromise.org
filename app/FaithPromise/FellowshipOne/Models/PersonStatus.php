<?php

namespace App\FaithPromise\FellowshipOne\Models;

/**
 * Class PersonStatus
 * @package App\FaithPromise\FellowshipOne\Models
 *
 * @method string getId()
 * @method string getUri()
 * @method string getName()
 * @method string getComment()
 * @method string getDate()
 * @method string getSubStatus()
 *
 * @method string setId($value)
 * @method string setUri($value)
 * @method string setName($value)
 * @method string setComment($value)
 * @method string setSubStatus($value)
 *
 */

class PersonStatus extends Base {

    protected $attributes = [
        'id'        => '@id',
        'uri'       => '@uri',
        'name'      => 'name',
        'comment'   => 'comment',
        'date'      => 'date',
        'subStatus' => ['subStatus', PersonSubStatus::class],
    ];

}