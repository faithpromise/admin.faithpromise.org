<?php

namespace App\Http\Controllers;

use App\FaithPromise\Zendesk\TicketFactory;
use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests;
use Huddle\Zendesk\Facades\Zendesk;
use Illuminate\Http\Request;

class SupportRequests extends BaseController {

    public function index(Request $request) {

        $user = $request->user();
        $tickets = Zendesk::users($user->zendesk_user_id)->tickets()->findAll();

        return response()->json($tickets);
    }

    public function store(Request $request) {

        $requester = $request->user();
        $ticket = $request->input('ticket');

        $ticket = TicketFactory::create($ticket['type'], $ticket, $requester);
        $ticket->save();

    }

    public function batchCreate(Request $request) {

        $requester = $request->user();
        $tickets = $request->input('requests');

        foreach ($tickets as $ticket) {
            $ticket = TicketFactory::create($ticket['meta']['type'], $ticket, $requester);
            $ticket->save();
        }

    }

}
