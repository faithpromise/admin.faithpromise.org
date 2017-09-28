<?php

namespace App\Http\Controllers;

use FaithPromise\Shared\Models\Staff;
use FaithPromise\Shared\Models\TicketRequirement;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketRequirementsController extends Controller {

    public function index(Request $request) {

        $requirements = TicketRequirement::with(['author' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }])->orderBy('sort');

        // Limit to certain tickets?
        if ($request->has('zendesk_ticket_ids')) {
            $requirements->whereIn('zendesk_ticket_id', explode(',', $request->input('zendesk_ticket_ids')));
        }

        $result = [
            'data' => $requirements->get()
        ];

        return \Response::json($result);

    }

    public function find($requirement_id) {

        $result = [
            'data' => TicketRequirement::find($requirement_id)
        ];

        return \Response::json($result);

    }

    public function store(Request $request) {

        $staffer = Staff::where('email', '=', $request->input('created_by_email'))->first();

        TicketRequirement::create([
            'zendesk_ticket_id' => $request->input('zendesk_ticket_id'),
            'title'             => $request->input('title'),
            'body'              => $request->input('body'),
            'sort'              => $request->input('sort'),
            'created_by'        => $staffer ? $staffer->id : null
        ]);

        // TODO: What should the response be?
        return '';
    }

    public function update(Request $request, $requirement_id) {

        $requirement = TicketRequirement::whereId($requirement_id)->first();
        $staffer = Staff::where('email', '=', $request->input('created_by_email'))->first();

        // Create an archive
        TicketRequirement::create([
            'parent_id'         => $requirement->id,
            'zendesk_ticket_id' => $requirement->zendesk_ticket_id,
            'title'             => $requirement->title,
            'body'              => $requirement->body,
            'sort'              => $requirement->sort,
            'created_by'        => $requirement->created_by
        ])->delete();

        // Update
        $requirement->title = $request->input('title', $requirement->title);
        $requirement->body = $request->input('body', $requirement->body);
        $requirement->sort = $request->input('sort', $requirement->sort);
        $requirement->created_by = $staffer ? $staffer->id : null;

        $requirement->save();

        // TODO: What should the response be?
        return '';
    }

    public function destroy($requirement_id) {

        TicketRequirement::whereId($requirement_id)->delete();

        // TODO: What should the response be?
        return '';

    }
}
