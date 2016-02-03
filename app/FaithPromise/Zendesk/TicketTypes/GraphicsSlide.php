<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use App\Models\User;
use Carbon\Carbon;
use FaithPromise\Shared\Models\TicketTask as Task;

class GraphicsSlide extends Ticket {

    protected $deliver_to = 'heatherb@faithpromise.org';
    protected $deliver_method = 'zendesk';

    protected $days_to_design = 7;
    protected $send_graphics_at;

    protected function createTasks($zendesk_ticket_id, User $requester) {

        Task::create([
            'title'             => 'Design Graphic',
            'due_at'            => $this->getSendGraphicsAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

    protected function createRequirements($zendesk_ticket_id) {
        // Currently no requirements
    }

    public function setDueDates() {
        // Slide graphics are due on Wednesdays
        // Easiest thing is to set it due today
        $this->setSendGraphicsAt(Carbon::now()->endOfDay());

    }

    private function getSendGraphicsAt() {
        return $this->send_graphics_at;
    }

    private function setSendGraphicsAt($value) {
        $this->send_graphics_at = $value;
        return $this;
    }

}