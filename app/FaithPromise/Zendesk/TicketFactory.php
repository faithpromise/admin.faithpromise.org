<?php
/**
 * Created by PhpStorm.
 * User: broberts
 * Date: 11/18/15
 * Time: 3:59 PM
 */

namespace App\FaithPromise\Zendesk;

class TicketFactory {

    public static function create($type, $ticket, $user) {

        $class_name = 'App\\Faithpromise\\Zendesk\\Tickets\\' . studly_case($type);

        if (class_exists($class_name)) {
            return new $class_name($ticket, $user);
        }

        return new Ticket($ticket, $user);

    }

}
