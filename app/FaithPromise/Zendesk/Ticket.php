<?php

namespace App\FaithPromise\Zendesk;

use Carbon\Carbon;
use FaithPromise\Shared\Models\Staff;
use Huddle\Zendesk\Facades\Zendesk;

abstract class Ticket {

    protected $deliver_to = 'brad-roberts';
    protected $deliver_method = 'email';
    private $zendesk_agent_ids = [];

    public function __construct($ticket, Staff $requester) {

        $this->ticket = $ticket;
        $this->requester = $requester;
        $this->recipient = Staff::findBySlug($this->deliver_to);

        // Carbonize the deliver_by date.
        if ($ticket['deliver_by']) {
            $this->ticket['deliver_by'] = Carbon::parse($ticket['deliver_by'], 'UTC')->setTimezone('America/New_York');
        }

    }

    abstract protected function createTasks($zendesk_ticket_id, Staff $requester);

    abstract protected function createRequirements($zendesk_ticket_id);

    public function save() {

        if ($this->deliver_method === 'zendesk') {
            return $this->sendViaZendesk();
        }

        return $this->sendViaEmail();

    }

    private function sendViaZendesk() {

        $zendesk_agent_id = $this->getZendeskAgentId();

        if (!$zendesk_agent_id) {
            return $this->sendViaEmail();
        }

        $ticket = [
            'type'         => 'task',
            'subject'      => $this->ticket['subject'],
            'comment'      => [
                'body' => $this->buildDescription()
            ],
            'requester_id' => $this->requester->zendesk_user_id,
            'assignee_id'  => $zendesk_agent_id,
            'priority'     => 'normal'
        ];

        if ($this->ticket['deliver_by']) {
            $ticket['due_at'] = $this->ticket['deliver_by']->format('Y-m-d');
        }

        $zendesk_ticket = Zendesk::tickets()->create($ticket);

        $this->createTasks($zendesk_ticket->ticket->id, $this->requester);
        $this->createRequirements($zendesk_ticket->ticket->id);

        return true;

    }

    private function getZendeskAgentId() {

        if (!array_key_exists($this->deliver_to, $this->zendesk_agent_ids)) {

            // If staff has zendesk_user_id, use it
            if ($this->recipient->zendesk_user_id) {

                $this->zendesk_agent_ids[$this->deliver_to] = $this->recipient->zendesk_user_id;

            } else {

                $zendesk_user_search = Zendesk::users()->search(['query' => $this->recipient->email]);

                if (!count($zendesk_user_search)) {
                    $this->zendesk_agent_ids[$this->deliver_to] = null;
                } else {
                    $this->zendesk_agent_ids[$this->deliver_to] = $zendesk_user_search->users[0]->id;
                }

            }

        }

        return $this->zendesk_agent_ids[$this->deliver_to];

    }

    private function sendViaEmail() {

        return true;

    }

    private function buildDescription() {

        $description = [];
        $desc = trim($this->ticket['description']);

        if (!empty($desc)) {
            $description[] = $desc;
        }

        if ($this->ticket['deliver_by']) {
            $description[] = 'Deliver by: ' . $this->ticket['deliver_by']->format('D, M j, Y');
        }

        if (empty($description)) {
            $description[] = 'No description or delivery date provided.';
        }

        return implode(PHP_EOL . PHP_EOL, $description);

    }

}