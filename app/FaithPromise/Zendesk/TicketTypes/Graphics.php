<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use FaithPromise\Shared\Models\TicketTask as Task;

class Graphics extends Ticket {

//    protected $deliver_to = 'heather-burson';
    protected $deliver_to = 'kyle-gilbert';
    protected $deliver_method = 'zendesk';

    protected function createTasks($zendesk_ticket_id) {
        return $this->createTasksForPrintPiece($zendesk_ticket_id);
    }

    private function createTasksForPrintPiece($zendesk_ticket_id) {

        // Create default tasks
        if (!$this->ticket['deliver_by']) {
            return;
        }

        Task::create([
            'title'             => 'Gather Requirements',
            'due_at'            => $this->ticket['deliver_by']->copy()->subDays(23),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Request Quote',
            'due_at'            => $this->ticket['deliver_by']->copy()->subDays(23),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Request P.O.',
            'due_at'            => $this->ticket['deliver_by']->copy()->subDays(22),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Deliver Proof',
            'due_at'            => $this->ticket['deliver_by']->copy()->subDays(9),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Proof Sign Off',
            'due_at'            => $this->ticket['deliver_by']->copy()->subDays(7),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Place Order',
            'due_at'            => $this->ticket['deliver_by']->copy()->subDays(7),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Product Delivered',
            'due_at'            => $this->ticket['deliver_by'],
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

}