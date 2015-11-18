<?php

namespace App\FaithPromise\Zendesk;

use FaithPromise\Shared\Models\Staff;

class Ticket {

    protected $driver = 'mail';

    public function __construct($ticket, $user) {

        $this->user = $user;
        $this->ticket = $ticket;
        $this->staff = Staff::findBySlug($this->staff_slug);

    }

    public final function save() {

        if ($this->driver === 'Zendesk') {
            return $this->saveToZendesk();
        }

        return $this->sendViaEmail();

    }

    private function saveToZendesk() {

        return $this;

    }

    private function sendViaEmail() {

        return $this;

    }

}