<?php

namespace App\FaithPromise\Zendesk\TicketTypes;

use App\FaithPromise\Zendesk\Ticket;
use App\Models\User;
use Carbon\Carbon;
use FaithPromise\Shared\Models\TicketTask as Task;

abstract class Graphics extends Ticket {

    protected $deliver_to = 'jaclynh@faithpromise.org';
    protected $deliver_method = 'email';

    /** @var  Carbon */
    protected $deliver_at;
    /** @var  Carbon */
    protected $place_order_at;
    /** @var  Carbon */
    protected $sign_off_at;
    /** @var  Carbon */
    protected $deliver_proof_at;
    /** @var  Carbon */
    protected $start_design_at;
    /** @var  Carbon */
    protected $copy_due_at;
    /** @var  Carbon */
    protected $meeting_at;
    /** @var  Carbon */
    protected $gather_requirements_at;
    /** @var  Carbon */
    protected $request_quote_at;
    /** @var  Carbon */
    protected $send_quote_at;

    protected function createTasks($zendesk_ticket_id, User $requester) {

        Task::create([
            'title'             => 'Schedule Meeting with ' . $requester->{'first_name'},
            'due_at'            => $this->getMeetingAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Requirements Gathered',
            'due_at'            => $this->getGatherRequirementsAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Start design work',
            'due_at'            => $this->getStartDesignAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Deliver Proof',
            'due_at'            => $this->getDeliverProofAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

        Task::create([
            'title'             => 'Proof Sign Off',
            'due_at'            => $this->getSignOffAt(),
            'zendesk_ticket_id' => $zendesk_ticket_id
        ]);

    }

    protected function createRequirements($zendesk_ticket_id) {
        // Currently no default requirements for graphics
    }

    /**
     * Place Order At
     * @return Carbon
     */
    public function getPlaceOrderAt() {
        return $this->place_order_at->copy();
    }

    public function setPlaceOrderAt($value) {
        $this->place_order_at = $value;

        return $this;
    }

    /**
     * Sign Off At
     * @return Carbon
     */
    public function getSignOffAt() {
        return $this->sign_off_at->copy();
    }

    public function setSignOffAt($value) {
        $this->sign_off_at = $value;

        return $this;
    }

    /**
     * Deliver Proof At
     * @return Carbon
     */
    public function getDeliverProofAt() {
        return $this->deliver_proof_at->copy();
    }

    public function setDeliverProofAt($value) {
        $this->deliver_proof_at = $value;

        return $this;
    }

    /**
     * Start Design At
     * @return Carbon
     */
    public function getStartDesignAt() {
        return $this->start_design_at->copy();
    }

    public function setStartDesignAt($value) {
        return $this->start_design_at = $value;
    }

    /**
     * Copy Due At
     * @return Carbon
     */
    public function getCopyDueAt() {
        return $this->copy_due_at->copy();
    }

    public function setCopyDueAt($value) {
        return $this->copy_due_at = $value;
    }

    /**
     * Meeting At
     * @return Carbon
     */
    public function getMeetingAt() {
        return $this->meeting_at->copy();
    }

    public function setMeetingAt($value) {
        return $this->meeting_at = $value;
    }

    /**
     * Requirements At
     * @return Carbon
     */
    public function getGatherRequirementsAt() {
        return $this->gather_requirements_at->copy();
    }

    public function setGatherRequirementsAt($value) {
        return $this->gather_requirements_at = $value;
    }

    /**
     * Request Quote At
     * @return Carbon
     */
    public function getRequestQuoteAt() {
        return $this->request_quote_at->copy();
    }

    public function setRequestQuoteAt($value) {
        return $this->request_quote_at = $value;
    }

    /**
     * Send Quote At
     * @return Carbon
     */
    public function getSendQuoteAt() {
        return $this->send_quote_at->copy();
    }

    public function setSendQuoteAt($value) {
        return $this->send_quote_at = $value;
    }

    protected function buildSubject() {
        return $this->ticket['subject'] . ' [' . $this->ticket['title'] . ']';
    }


}