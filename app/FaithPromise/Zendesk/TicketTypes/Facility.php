<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use App\Models\User;

class Facility extends Ticket {

    protected $deliver_to = 'sids@faithpromise.org';
    protected $deliver_to_pel = 'martiw@faithpromise.org';
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

    public function getDeliverTo() {
        if ($this->campus && $this->campus->slug === 'pellissippi') {
            return $this->deliver_to_pel;
        }

        return $this->deliver_to;
    }

    protected function buildSubject() {
        if ($this->campus) {
            return $this->ticket['subject'] . ' [' . $this->campus->name . ']';
        }

        return $this->ticket['subject'];
    }
}