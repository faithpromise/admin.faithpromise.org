<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use App\Models\User;
use FaithPromise\Shared\Models\TicketTask as Task;

class Website extends Ticket {

    protected $deliver_to = 'bradr@faithpromise.org';
    protected $deliver_method = 'zendesk';

    protected function setDueDates() {
        // Currently no need to set due dates for website updates
    }

    protected function createTasks($zendesk_ticket_id, User $requester) {

        Task::create([
            'title'             => 'Make the Update',
            'due_at'            => $this->getDeliverAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

    protected function createRequirements($zendesk_ticket_id) {
        // Currently no default requirements for website updates
    }
}