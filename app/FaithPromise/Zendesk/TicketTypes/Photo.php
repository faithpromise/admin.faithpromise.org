<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use Carbon\Carbon;
use FaithPromise\Shared\Models\Staff;
use FaithPromise\Shared\Models\TicketTask as Task;
use FaithPromise\Shared\Models\TicketRequirement as Requirement;

class Photo extends Graphics {

    protected $deliver_to = 'kyle-gilbert';
    protected $deliver_method = 'zendesk';

    protected function createTasks($zendesk_ticket_id, Staff $requester) {

        $today = Carbon::now()->endOfDay();

        // Work backwards from delivery date
        $deliver_at = $this->ticket['deliver_by']->endOfDay();

        Task::create([
            'title'             => 'Schedule Meeting with ' . $requester->first_name,
            'due_at'            => $today,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Communicate with photography team leader',
            'due_at'            => $today,
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Confirm photographer',
            'due_at'            => $deliver_at->copy()->subWeekdays(7)->endOfDay(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Send update to ' . $requester->first_name,
            'due_at'            => $deliver_at->copy()->subWeekdays(7)->endOfDay(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Deliver photos to ' . $requester->first_name,
            'due_at'            => $deliver_at->copy()->addDays(3)->endOfDay(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);
    }

    protected function createRequirements($zendesk_ticket_id) {

        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Where']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Start and end time']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Who\'s responsible for set up?']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Types of photos']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 2, 'title' => 'Photo booth?']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'Backdrop and props']);

    }

}