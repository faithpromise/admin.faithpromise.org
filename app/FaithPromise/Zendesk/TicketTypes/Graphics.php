<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use Carbon\Carbon;
use FaithPromise\Shared\Models\Staff;
use FaithPromise\Shared\Models\TicketTask as Task;

class Graphics extends Ticket {

//    protected $deliver_to = 'heather-burson';
    protected $deliver_to = 'kyle-gilbert';
    protected $deliver_method = 'zendesk';

    protected function createTasks($zendesk_ticket_id, Staff $requester) {
        return $this->createTasksForPrintPiece($zendesk_ticket_id, $requester);
    }

    protected function createTasksForPrintPiece($zendesk_ticket_id, $requester) {

        // Create default tasks
        if (!$this->ticket['deliver_by']) {
            return;
        }

        $now = Carbon::now()->endOfDay();

        Task::create([
            'title'             => 'Schedule Meeting with ' . $requester->first_name,
            'due_at'            => $now->copy(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Requirements Gathered',
            'due_at'            => $now->copy()->addDays(2),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Request Quote from Vendor',
            'due_at'            => $now->copy()->addDays(2),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Send Quote to ' . $requester->first_name,
            'due_at'            => $now->copy()->addDays(4),
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

    protected function createTasksForDigitalPiece($zendesk_ticket_id) {

        // TODO: Decide on dates for digital piece

        // Create default tasks
        if (!$this->ticket['deliver_by']) {
            return;
        }

        $now = Carbon::now()->startOfDay();

        Task::create([
            'title'             => 'Gather Requirements',
            'due_at'            => $now->copy()->addDays(2),
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