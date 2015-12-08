<?php

namespace App\Http\Controllers;

use App\FaithPromise\Zendesk\TicketFactory;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Huddle\Zendesk\Facades\Zendesk;

class SupportRequests extends Controller {

    public function index(Request $request) {

        $user = $request->user();
        $tickets = Zendesk::users($user->zendesk_user_id)->tickets()->findAll();

        return response()->json($tickets);
    }

    public function store(Request $request) {

        $requester = $request->user()->Staff;
        $ticket = $request->input('ticket');

        $ticket = TicketFactory::create($ticket['type'], $ticket, $requester);
        $ticket->save();

    }

    public function batchCreate(Request $request) {

        $requester = $request->user()->Staff;
        $tickets = $request->input('requests');

        foreach ($tickets as $ticket) {
            $ticket = TicketFactory::create($ticket['meta']['type'], $ticket, $requester);
            $ticket->save();
        }

        dd($tickets);

    }

}
