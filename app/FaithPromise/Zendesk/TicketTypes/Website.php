<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use Carbon\Carbon;
use FaithPromise\Shared\Models\Staff;
use FaithPromise\Shared\Models\TicketTask as Task;
use FaithPromise\Shared\Models\TicketRequirement as Requirement;

class Website extends Graphics {

//    protected $deliver_to = 'heather-burson';
    protected $deliver_to = 'brad-roberts';
    protected $deliver_method = 'zendesk';

}