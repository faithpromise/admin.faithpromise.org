<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\Models\User;
use FaithPromise\Shared\Models\TicketTask as Task;
use FaithPromise\Shared\Models\TicketRequirement as Requirement;

class GraphicsSign extends PrintGraphics {

    protected function createTasks($zendesk_ticket_id, User $requester) {

        parent::createTasks($zendesk_ticket_id, $requester);

        Task::create([
            'title'             => 'Hang Sign(s)',
            'due_at'            => $this->getDeliverAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

    protected function createRequirements($zendesk_ticket_id) {

        parent::createRequirements($zendesk_ticket_id);

        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Sign Location']);

    }

}