<?php

namespace App\FaithPromise\Zendesk;

use Carbon\Carbon;
use FaithPromise\Shared\Models\Staff;
use Huddle\Zendesk\Facades\Zendesk;

class Ticket {

    protected $driver = 'mail';
    private $zendesk_users = [];

    public function __construct($ticket, $user) {

        $this->requester = $user;
        $this->ticket = $ticket;
        $this->agent = Staff::findBySlug($this->agent);

        if ($ticket['deliver_by']) {
            $ticket['deliver_by'] = Carbon::parse($ticket['deliver_by'], 'UTC')->setTimezone('America/New_York');
        }

    }

    public final function save() {

        if ($this->driver === 'zendesk') {
            return $this->saveToZendesk();
        }

        return $this->sendViaEmail();

    }

    private function saveToZendesk() {

        $zendesk_user_id = $this->getZendeskUser();

        if (!$zendesk_user_id) {
            return $this->sendViaEmail();
        }

        Zendesk::tickets()->create([
            'subject' => $this->ticket['subject'],
            'comment' => [
                'body' => $this->buildDescription()
            ],
            'requester_id' => $this->requester->zendesk_user_id,
            'assignee_id' => $zendesk_user_id,
            'priority' => 'normal'
        ]);

        return $this;

    }

    private function getZendeskUser() {

        if (isset($this->zendesk_users[$this->agent])) {

            $zendesk_user_search = Zendesk::users()->search(['query' => $this->agent->email]);

            if (!count($zendesk_user_search)) {
                $this->zendesk_users[$this->agent] = null;
            } else {
                $this->zendesk_users[$this->agent] = $zendesk_user_search->users[0]->id;
            }

        }

        return $this->zendesk_users[$this->agent];

    }

    private function sendViaEmail() {



        return $this;

    }

    private function buildDescription() {



        return $this->ticket['description'];

    }

}