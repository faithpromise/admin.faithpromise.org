<?php

namespace App\FaithPromise\Zendesk;

class TicketFactory {

    /**
     * @param $type
     * @param $ticket
     * @param $user
     * @return Ticket
     * @throws \Exception
     */
    public static function create($type, $ticket, $user) {

        $class_name = '\\App\\Faithpromise\\Zendesk\\TicketTypes\\' . studly_case($type);

        if (class_exists($class_name)) {
            return new $class_name($ticket, $user);
        }

        throw new \Exception('No TicketType class found for: ' . $class_name);

    }

}
