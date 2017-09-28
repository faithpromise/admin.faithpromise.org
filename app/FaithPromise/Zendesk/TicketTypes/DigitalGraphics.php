<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use Carbon\Carbon;
use FaithPromise\Shared\Models\TicketTask as Task;
use App\Models\User;

abstract class DigitalGraphics extends Graphics {

    protected $days_to_design = 14;
    protected $days_to_iterate_proof = 2;
    protected $days_to_meet = 2;

    public function setDueDates() {
        $this->setDeliverAt($this->getDeliverAt()->endOfDay());
        $this->setSignOffAt($this->getDeliverAt()->endOfDay());
        $this->setDeliverProofAt($this->getSignOffAt()->subWeekdays($this->days_to_iterate_proof)->endOfDay());
        $this->setStartDesignAt($this->getDeliverProofAt()->subWeekdays($this->days_to_design)->endOfDay());
        $this->setCopyDueAt($this->getDeliverProofAt()->subWeekdays($this->days_to_design)->endOfDay());

        if ($this->getStartDesignAt()->isFuture()) {
            $this->setMeetingAt(Carbon::now()->endOfDay());
            $this->setGatherRequirementsAt(Carbon::now()->addWeekdays($this->days_to_meet)->endOfDay());
        } else {
            $last_weekday = $this->getStartDesignAt()->subWeekdays(1)->endOfDay();
            $this->setMeetingAt($last_weekday);
            $this->setGatherRequirementsAt($last_weekday);
        }

    }

    protected function createTasks($zendesk_ticket_id, User $requester) {

        // Create default tasks
        if (!$this->getDeliverAt()) {
            return;
        }

        parent::createTasks($zendesk_ticket_id, $requester);

        Task::create([
            'title'             => 'Copy due',
            'due_at'            => $this->getCopyDueAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Graphics Placed',
            'due_at'            => $this->getDeliverAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

}