<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use Carbon\Carbon;
use FaithPromise\Shared\Models\Staff;
use FaithPromise\Shared\Models\TicketTask as Task;

class Graphics extends Ticket {

    protected $deliver_to = 'kyle-gilbert';
    protected $deliver_method = 'zendesk';

    protected function createRequirements($zendesk_ticket_id) {
    }

    protected function createTasks($zendesk_ticket_id, Staff $requester) {
        return $this->createTasksForPrintPiece($zendesk_ticket_id, $requester);
    }

    protected function createTasksForPrintPiece($zendesk_ticket_id, $requester) {

        // Create default tasks
        if (!$this->ticket['deliver_by']) {
            return;
        }

        $now = Carbon::now()->endOfDay();

        // Change these
        $days_to_design = 14;
        $days_to_iterate_proof = 2;
        $days_to_deliver = 7;
        $days_to_meet = 2;
        $days_to_quote_turnaround = 2;

        // Work backwards from delivery date
        $deliver_at = $this->ticket['deliver_by']->endOfDay();
        $place_order_at = $deliver_at->copy()->subWeekdays($days_to_deliver)->endOfDay();
        $sign_off_at = $place_order_at->copy();
        $deliver_proof_at = $sign_off_at->copy()->subWeekdays($days_to_iterate_proof)->endOfDay();
        $start_design_at = $deliver_proof_at->copy()->subWeekdays($days_to_design)->endOfDay();
        $copy_due_at = $start_design_at->copy();

        // Work forwards from now
        $schedule_meeting_at = $now->copy();
        $gather_requirements_at = $now->copy()->addWeekdays($days_to_meet)->endOfDay();
        $request_quote_at = $now->copy()->addWeekdays($days_to_meet)->endOfDay();
        $send_quote_at = $request_quote_at->copy()->addWeekdays($days_to_quote_turnaround)->endOfDay();

        // If starting project in the past, adjust our dates
        if ($start_design_at->isPast()) {
            $schedule_meeting_at = $start_design_at->copy()->subWeekdays(1)->endOfDay();
            $gather_requirements_at = $schedule_meeting_at;
            $request_quote_at = $schedule_meeting_at;
            $send_quote_at = $schedule_meeting_at;
            $copy_due_at = $schedule_meeting_at;
        }

        Task::create([
            'title'             => 'Schedule Meeting with ' . $requester->first_name,
            'due_at'            => $schedule_meeting_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Requirements Gathered',
            'due_at'            => $gather_requirements_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Request Quote from Vendor',
            'due_at'            => $request_quote_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Send Quote to ' . $requester->first_name,
            'due_at'            => $send_quote_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Copy due',
            'due_at'            => $copy_due_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Start design work',
            'due_at'            => $start_design_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Deliver Proof',
            'due_at'            => $deliver_proof_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Proof Sign Off',
            'due_at'            => $sign_off_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Place Order',
            'due_at'            => $place_order_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Product Delivered',
            'due_at'            => $deliver_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

    protected function createTasksForDigitalPiece($zendesk_ticket_id, $requester) {

        // Create default tasks
        if (!$this->ticket['deliver_by']) {
            return;
        }

        $now = Carbon::now()->endOfDay();

        // Change these
        $days_to_design = 14;
        $days_to_iterate_proof = 2;
        $days_to_meet = 2;

        // Work backwards from delivery date
        $deliver_at = $this->ticket['deliver_by']->endOfDay();
        $sign_off_at = $deliver_at->copy();
        $deliver_proof_at = $sign_off_at->copy()->subWeekdays($days_to_iterate_proof)->endOfDay();
        $start_design_at = $deliver_proof_at->copy()->subWeekdays($days_to_design)->endOfDay();
        $copy_due_at = $start_design_at->copy();

        // Work forwards from now
        $schedule_meeting_at = $now->copy();
        $gather_requirements_at = $now->copy()->addWeekdays($days_to_meet)->endOfDay();

        // If starting project in the past, adjust our dates
        if ($start_design_at->isPast()) {
            $schedule_meeting_at = $start_design_at->copy()->subWeekdays(1)->endOfDay();
            $gather_requirements_at = $schedule_meeting_at;
        }

        Task::create([
            'title'             => 'Schedule Meeting with ' . $requester->first_name,
            'due_at'            => $schedule_meeting_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Requirements Gathered',
            'due_at'            => $gather_requirements_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Copy due',
            'due_at'            => $copy_due_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Start design work',
            'due_at'            => $start_design_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Deliver Proof',
            'due_at'            => $deliver_proof_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Proof Sign Off',
            'due_at'            => $sign_off_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Product Delivered',
            'due_at'            => $deliver_at,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

}