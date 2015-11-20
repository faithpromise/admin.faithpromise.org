<?php

namespace App\Http\Middleware;

use Closure;
use Huddle\Zendesk\Facades\Zendesk;

class ZendeskUserId {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $staffer = $request->user()->Staff;

        if (!$staffer->zendesk_user_id) {

            // Search for user
            $zendesk_user_search = Zendesk::users()->search(['query' => $staffer->email]);

            // Assign zendesk id
            if (count($zendesk_user_search->users)) {

                $staffer->zendesk_user_id = $zendesk_user_search->users[0]->id;

                // Create zendesk user and assign id
            } else {

                $response = Zendesk::users()->create([
                    'name'     => $staffer->name,
                    'email'    => $staffer->email,
                    'verified' => true
                ]);

                $staffer->zendesk_user_id = $response->user->id;

            }

            $staffer->save();

        }

        return $next($request);

    }
}
