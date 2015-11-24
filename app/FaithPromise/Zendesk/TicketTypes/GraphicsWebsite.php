<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use FaithPromise\Shared\Models\Staff;

class GraphicsWebsite extends Graphics {

    protected $deliver_to = 'brad-roberts';
    protected $deliver_method = 'zendesk';

    protected function createTasks($zendesk_ticket_id, Staff $requester) {

        // Create default tasks
        if (!$this->ticket['deliver_by']) {
            return;
        }



    }

}