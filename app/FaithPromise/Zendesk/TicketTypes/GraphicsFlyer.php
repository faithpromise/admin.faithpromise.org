<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use FaithPromise\Shared\Models\TicketRequirement as Requirement;

class GraphicsFlyer extends Graphics {

    protected $deliver_to = 'heatherb@faithpromise.org';
    protected $deliver_method = 'zendesk';

    protected function createRequirements($zendesk_ticket_id) {

        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Style']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 2, 'title' => 'Professional printing?']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'Quantity']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'How are you going to use this piece?']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'Color specifications']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'Are you providing text?']);

    }

}