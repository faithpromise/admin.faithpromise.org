<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use Carbon\Carbon;
use FaithPromise\Shared\Models\TicketTask as Task;
use FaithPromise\Shared\Models\TicketRequirement as Requirement;
use App\Models\User;

abstract class PrintGraphics extends Graphics {

    protected $days_to_design = 14;
    protected $days_to_iterate_proof = 2;
    protected $days_to_deliver = 7;
    protected $days_to_meet = 2;
    protected $days_to_quote_turnaround = 2;

    public function setDueDates() {
        $this->setDeliverAt($this->getDeliverAt()->endOfDay());
        $this->setPlaceOrderAt($this->getDeliverAt()->subWeekdays($this->days_to_deliver)->endOfDay());
        $this->setSignOffAt($this->getDeliverAt()->subWeekdays($this->days_to_deliver)->endOfDay());
        $this->setDeliverProofAt($this->getPlaceOrderAt()->subWeekdays($this->days_to_iterate_proof)->endOfDay());
        $this->setStartDesignAt($this->getDeliverProofAt()->subWeekdays($this->days_to_design)->endOfDay());

        if ($this->getStartDesignAt()->isFuture()) {
            $this->setMeetingAt(Carbon::now()->endOfDay());
            $this->setGatherRequirementsAt(Carbon::now()->addWeekdays($this->days_to_meet)->endOfDay());
            $this->setRequestQuoteAt(Carbon::now()->addWeekdays($this->days_to_meet)->endOfDay());
            $this->setSendQuoteAt(Carbon::now()->addWeekdays($this->days_to_quote_turnaround)->endOfDay());
            $this->setCopyDueAt($this->getStartDesignAt());
        } else {
            $last_weekday = $this->getStartDesignAt()->subWeekdays(1)->endOfDay();
            $this->setMeetingAt($last_weekday);
            $this->setGatherRequirementsAt($last_weekday);
            $this->setRequestQuoteAt($last_weekday);
            $this->setSendQuoteAt($last_weekday);
            $this->setCopyDueAt($last_weekday);
        }

    }

    protected function createTasks($zendesk_ticket_id, User $requester) {

        // Create default tasks
        if (!$this->getDeliverAt()) {
            return;
        }

        parent::createTasks($zendesk_ticket_id, $requester);

        Task::create([
            'title'             => 'Request Quote from Vendor',
            'due_at'            => $this->getRequestQuoteAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Send Quote to ' . $requester->{'first_name'},
            'due_at'            => $this->getSendQuoteAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Copy due',
            'due_at'            => $this->getCopyDueAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Place Order',
            'due_at'            => $this->getPlaceOrderAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Product Delivered',
            'due_at'            => $this->getDeliverAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

    protected function createRequirements($zendesk_ticket_id) {

        parent::createRequirements($zendesk_ticket_id);

        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Specifics (times, location, etc)']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 1, 'title' => 'Design References']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 2, 'title' => 'Professional printing?']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'Quantity']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'How are you going to use this piece?']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'Color specifications']);
        Requirement::create(['zendesk_ticket_id' => $zendesk_ticket_id, 'sort' => 3, 'title' => 'Are you providing text?']);

    }

}