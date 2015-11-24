<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use FaithPromise\Shared\Models\Staff;
use FaithPromise\Shared\Models\TicketTask;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketTasksController extends Controller {

    public function index($zendesk_ticket_id) {

        $result = [
            'tasks' => TicketTask::with(['finisher' => function($query) {
                $query->select('id', 'first_name', 'last_name');
            }])->where('zendesk_ticket_id', '=', $zendesk_ticket_id)->get()
        ];

        return \Response::json($result);

    }

    public function store(Request $request, $zendesk_ticket_id) {

        $data = [
            'zendesk_ticket_id' => $zendesk_ticket_id,
            'title' => $request->input('title'),
            'due_at' => empty($request->input('due_at')) ? null : Carbon::createFromFormat(Carbon::ISO8601, $request->input('due_at'))
        ];

        TicketTask::create($data);

        // TODO: What should the response be?
        return '';
    }

    public function update(Request $request, $zendesk_ticket_id, $task_id) {

        $task = TicketTask::where('zendesk_ticket_id', '=', $zendesk_ticket_id)->where('id', '=', $task_id)->firstOrFail();

        if ($request->input('completed_at') !== null) {
            $task->completed_at = empty($request->input('completed_at')) ? null : Carbon::createFromFormat(Carbon::ISO8601, $request->input('completed_at'));
        }

        if (! empty($request->input('completed_by'))) {
            $staffer = Staff::where('email', '=', $request->input('completed_by'))->first();
            $task->completed_by = $staffer ? $staffer->id : null;
        }

        $task->save();

        // TODO: What should the response be?
        return '';

    }


    public function destroy($zendesk_ticket_id, $task_id) {

        TicketTask::where('zendesk_ticket_id', '=', $zendesk_ticket_id)->where('id', '=', $task_id)->delete();

        // TODO: What should the response be?
        return '';

    }
}
