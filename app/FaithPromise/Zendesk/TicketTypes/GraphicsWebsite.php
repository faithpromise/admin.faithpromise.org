<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\Models\User;

class GraphicsWebsite extends Graphics {

    protected $deliver_to = 'bradr@faithpromise.org';
    protected $deliver_method = 'zendesk';

    protected function createTasks($zendesk_ticket_id, User $requester) {

        // Create default tasks
        if (!$this->ticket['deliver_by']) {
            return;
        }



    }

}