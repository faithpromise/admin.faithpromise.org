<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use FaithPromise\Shared\Models\Staff;
use FaithPromise\Shared\Models\TicketTask;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketTasksController extends Controller {

    public function index(Request $request) {

        $tasks = TicketTask::with(['finisher' => function($query) {
            $query->select('id', 'first_name', 'last_name');
        }])->where(function($query) {
            $completed_after = Carbon::now()->startOfDay()->subDays(10);
            $query->whereNull('completed_at')->orWhere('completed_at', '>', $completed_after);
        })->orderBy('due_at')->orderBy('id');

        // Limit to certain tickets?
        if ($request->has('zendesk_ticket_ids')) {
            $tasks->whereIn('zendesk_ticket_id', explode(',', $request->input('zendesk_ticket_ids')));
        }

        $result = [
            'tasks' => $tasks->get()
        ];

        return \Response::json($result);

    }

    public function byTicket($zendesk_ticket_id) {

        $result = [
            'tasks' => TicketTask::with(['finisher' => function($query) {
                $query->select('id', 'first_name', 'last_name');
            }])->where('zendesk_ticket_id', '=', $zendesk_ticket_id)->orderBy('due_at')->orderBy('id')->get()
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

    public function update(Request $request, $task_id) {

        $task = TicketTask::where('id', '=', $task_id)->firstOrFail();
        $due_at = $request->input('due_at');
        $completed_at = $request->input('completed_at');
        $completed_by_email = $request->input('completed_by_email');

        // title
        if ($request->has('title')) {
            $task->title = $request->input('title');
        }

        // due_at provided
        if ($due_at !== null && strlen($due_at)) {
            $task->due_at = Carbon::createFromFormat(Carbon::ISO8601, $due_at);;
        }

        // completed_at provided
        if ($completed_at !== null && strlen($completed_at)) {
            $task->completed_at = Carbon::createFromFormat(Carbon::ISO8601, $completed_at);;
        }

        // completed_at is not empty
        if ($completed_by_email !== null && strlen($completed_by_email)) {
            $staffer = Staff::where('email', '=', $request->input('completed_by_email'))->first();
            $task->completed_by = $staffer ? $staffer->id : null;
        }

        // completed_at provided, but empty indicating it should be cleared
        if ($completed_at === '') {
            $task->completed_at = null;
            $task->completed_by = null;
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
