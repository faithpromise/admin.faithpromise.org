<?php

namespace App\FaithPromise\Zendesk;

use App\Models\User;
use Carbon\Carbon;
use FaithPromise\Shared\Models\Campus;
use FaithPromise\Shared\Models\Staff;
use Huddle\Zendesk\Facades\Zendesk;
use Illuminate\Support\Facades\Mail;

abstract class Ticket {

    protected $deliver_to = 'jaclynh@faithpromise.org';
    protected $deliver_method = 'email';
    private $zendesk_agent_ids = [];

    /** @var Carbon */
    protected $deliver_at;
    /** @var  Campus|null */
    protected $campus;

    public function __construct($ticket, User $requester) {
        $this->ticket = $ticket;
        $this->requester = $requester;
        $this->setDeliverAt(array_key_exists('deliver_by', $ticket) ? $ticket['deliver_by'] : null);
        $this->setDueDates();
        $this->setCampus();
    }

    abstract protected function setDueDates();

    abstract protected function createTasks($zendesk_ticket_id, User $requester);

    abstract protected function createRequirements($zendesk_ticket_id);

    public function save() {

        if ($this->deliver_method === 'zendesk') {
            return $this->saveToZendesk();
        }

        return $this->sendViaEmail();

    }

    private function saveToZendesk() {

        $zendesk_agent_id = $this->getZendeskAgentId();

        if (!$zendesk_agent_id) {
            return $this->sendViaEmail();
        }

        $ticket = [
            'type'         => 'task',
            'subject'      => $this->buildSubject(),
            'comment'      => [
                'body' => $this->buildDescription()
            ],
            'requester_id' => $this->requester->{'zendesk_user_id'},
            'assignee_id'  => $zendesk_agent_id,
            'priority'     => 'normal'
        ];

        if ($this->getDeliverAt()) {
            $ticket['due_at'] = $this->getDeliverAt()->format('Y-m-d');
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $zendesk_ticket = Zendesk::tickets()->create($ticket);

        $this->createTasks($zendesk_ticket->ticket->id, $this->requester);
        $this->createRequirements($zendesk_ticket->ticket->id);

        return true;

    }

    private function getZendeskAgentId() {

        $deliver_to = $this->getDeliverTo();

        if (!array_key_exists($deliver_to, $this->zendesk_agent_ids)) {

            /** @noinspection PhpUndefinedMethodInspection */
            $zendesk_user_search = Zendesk::users()->search(['query' => $deliver_to]);

            if (!count($zendesk_user_search)) {
                $this->zendesk_agent_ids[$deliver_to] = null;
            } else {
                $this->zendesk_agent_ids[$deliver_to] = $zendesk_user_search->users[0]->id;
            }

        }

        return $this->zendesk_agent_ids[$deliver_to];

    }

    private function sendViaEmail() {

        $deliver_to = $this->getDeliverTo();

        // ilike for case sensitive Postgres
        /** @noinspection PhpUndefinedMethodInspection */
        $recipient = Staff::where('email', 'ilike', '%' . $deliver_to . '%')->first();
        $requester = $this->requester;
        $subject = $this->ticket['subject'];
        if (array_key_exists('title', $this->ticket)) {
            $subject = $this->ticket['subject'] . ' [' . $this->ticket['title'] . ']';
        }

        if ($recipient) {
            Mail::send('emails.ticket', ['comment' => $this->buildDescription()], function($m) use ($recipient, $requester, $subject) {
                $m->subject($subject);
                $m->to($recipient->email, $recipient->name);
                $m->bcc('bradr@faithpromise.org', 'Brad Roberts');
                $m->from($requester->email, $requester->name);
            });
        }

        return true;

    }

    protected function buildSubject() {
        return $this->ticket['subject'];
    }

    private function buildDescription() {

        $description = [];
        $desc = trim(array_key_exists('description', $this->ticket) ? $this->ticket['description'] : '');

        if (!empty($desc)) {
            $description[] = $desc . PHP_EOL;
        }

        if ($this->getDeliverAt()) {
            $description[] = 'Deliver by: ' . $this->getDeliverAt()->format('D, M j, Y');
        }

        $description[] = 'Submitted by: ' . $this->requester->getNameAttribute();

        return implode(PHP_EOL, $description);

    }

    /**
     * @return Carbon
     */
    protected function getDeliverAt() {
        return $this->deliver_at->copy();
    }

    public function setDeliverAt($value) {
        $carbonized_value = Carbon::parse($value, 'UTC');
        $this->deliver_at = $carbonized_value ? $carbonized_value->setTimezone('America/New_York') : null;

        return $this;
    }

    public function getDeliverTo() {
        return $this->deliver_to;
    }

    private function setCampus() {
        if (array_key_exists('campus_id', $this->ticket)) {
            $this->campus = Campus::find($this->ticket['campus_id']);
        } else {
            $this->campus = null;
        }
    }

}