<?php

namespace App\FaithPromise\Zendesk\TicketTypes;
use FaithPromise\Shared\Models\TicketRequirement as Requirement;

use App\Models\User;

class GraphicsApparel extends PrintGraphics {

    protected $days_to_deliver = 18;

    protected function createTasks($zendesk_ticket_id, User $requester) {

        parent::createTasks($zendesk_ticket_id, $requester);

    }

    protected function createRequirements($zendesk_ticket_id) {

        parent::createRequirements($zendesk_ticket_id);

        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Color requests / limitations']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Imprint colors']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Quantities for each size, fit, and shirt color']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Imprint colors']);

    }

}