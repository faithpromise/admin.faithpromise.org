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

        $user = $request->user();

        if (!$user->zendesk_user_id) {

            // Search for user
            $zendesk_user_search = Zendesk::users()->search(['query' => $user->email]);
//            $zendesk_user_search = Zendesk::users()->search(['query' => 'bradley@faithpromise.org']);


            if (count($zendesk_user_search->users)) {

                // Assign user
                $user->zendesk_user_id = $zendesk_user_search->users[0]->id;

            } else {

                // Create user
                $response = Zendesk::users()->create([
                    'name'     => $user->name,
                    'email'    => $user->email,
                    'verified' => true
                ]);

                $user->zendesk_user_id = $response->user->id;

            }

            $user->save();

        }

        return $next($request);

    }
}
