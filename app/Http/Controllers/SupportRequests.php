<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Huddle\Zendesk\Facades\Zendesk;
use Tymon\JWTAuth\Facades\JWTAuth;

class SupportRequests extends Controller {

    public function listRequests() {

        $user = JWTAuth::parseToken()->authenticate();
        $tickets = Zendesk::users($user->zendesk_user_id)->tickets()->findAll();

        return response()->json($tickets);
    }

}
