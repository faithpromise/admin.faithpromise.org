<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\Models\User;
use FaithPromise\Shared\Models\TicketTask as Task;

class GraphicsSeatCard extends PrintGraphics {

    protected function createTasks($zendesk_ticket_id, User $requester) {

        parent::createTasks($zendesk_ticket_id, $requester);

        Task::create([
            'title'             => 'Approval',
            'due_at'            => $this->getMeetingAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

    protected function createRequirements($zendesk_ticket_id) {

        parent::createRequirements($zendesk_ticket_id);

    }

}