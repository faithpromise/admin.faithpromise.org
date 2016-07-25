<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use App\Models\User;
use Carbon\Carbon;
use FaithPromise\Shared\Models\TicketTask as Task;
use FaithPromise\Shared\Models\TicketRequirement as Requirement;

class Photo extends Ticket {

    protected $deliver_to = 'bradr@faithpromise.org';
    protected $deliver_method = 'email';

    /** @var  Carbon */
    protected $meeting_at;
    /** @var  Carbon */
    protected $communicate_with_leader_at;
    /** @var  Carbon */
    protected $update_requester_at;
    /** @var  Carbon */
    protected $confirm_photographer_at;
    /** @var  Carbon */
    protected $deliver_photos_at;

    protected function createTasks($zendesk_ticket_id, User $requester) {

        if (!$this->getDeliverAt()) {
            return;
        }

        Task::create([
            'title'             => 'Schedule Meeting with ' . $requester->{'first_name'},
            'due_at'            => $this->getMeetingAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Communicate with photography team leader',
            'due_at'            => $this->getCommunicateWithTeamLeaderAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Confirm photographer',
            'due_at'            => $this->getConfirmPhotographerAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Send update to ' . $requester->{'first_name'},
            'due_at'            => $this->getUpdateRequesterAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Deliver photos to ' . $requester->{'first_name'},
            'due_at'            => $this->getDeliverPhotosAt(),
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

    protected function setDueDates() {
        $today = Carbon::now()->endOfDay();

        $this->setMeetingAt($today);
        $this->setCommunicateWithTeamLeaderAt($today);
        $this->setConfirmPhotographerAt($this->getDeliverAt()->subWeekdays(7)->endOfDay());
        $this->setUpdateRequesterAt($this->getDeliverAt()->subWeekdays(7)->endOfDay());
        $this->setDeliverPhotosAt($this->getDeliverAt()->addDays(3)->endOfDay());
    }

    private function getMeetingAt() {
        return $this->meeting_at;
    }

    private function setMeetingAt($value) {
        $this->meeting_at = $value;

        return $this;
    }

    private function getCommunicateWithTeamLeaderAt() {
        return $this->communicate_with_leader_at->copy();
    }

    private function setCommunicateWithTeamLeaderAt($value) {
        $this->communicate_with_leader_at = $value;

        return $this;
    }

    private function getConfirmPhotographerAt() {
        return $this->confirm_photographer_at->copy();
    }

    private function setConfirmPhotographerAt($value) {
        $this->confirm_photographer_at = $value;

        return $this;
    }

    private function getUpdateRequesterAt() {
        return $this->update_requester_at->copy();
    }

    private function setUpdateRequesterAt($value) {
        $this->update_requester_at = $value;

        return $this;
    }

    private function getDeliverPhotosAt() {
        return $this->deliver_photos_at->copy();
    }

    private function setDeliverPhotosAt($value) {
        $this->deliver_photos_at = $value;

        return $this;
    }
}