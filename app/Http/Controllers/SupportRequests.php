<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Huddle\Zendesk\Facades\Zendesk;
use Tymon\JWTAuth\Facades\JWTAuth;

class SupportRequests extends Controller {

    public function listRequests(Request $request) {

        $email = JWTAuth::parseToken()->authenticate()->email;
        $email = 'ginam@faithpromise.org';
        // TODO: Remove test email

        $user_search = Zendesk::users()->search(['query' => $email]);
        $user = $user_search->users[0];

        $tickets = Zendesk::users($user->id)->tickets()->findAll();

        return response()->json($tickets);
    }

}
