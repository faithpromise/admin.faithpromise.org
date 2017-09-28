<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\Models\User;

class GraphicsInviteCard extends PrintGraphics {

    protected function createTasks($zendesk_ticket_id, User $requester) {

        parent::createTasks($zendesk_ticket_id, $requester);

    }

    protected function createRequirements($zendesk_ticket_id) {

        parent::createRequirements($zendesk_ticket_id);

    }

}