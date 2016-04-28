<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use App\Models\User;

class Facility extends Ticket {

    protected $deliver_to = 'martiw@faithpromise.org';
    protected $deliver_method = 'zendesk';

    protected function setDueDates() {
        // Currently no need to set due dates for website updates
    }

    protected function createTasks($zendesk_ticket_id, User $requester) {
        // Currently no tasks
    }

    protected function createRequirements($zendesk_ticket_id) {
        // Currently no default requirements for website updates
    }
}