<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Models\User;
use App\FaithPromise\FellowshipOne\ClientFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController {

    /**
     * Called by client (Satellizer) to get an OAuth request token
     * from FellowshipOne, then a second time to get access token.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request) {

        // First step for request token
        if (!$request->has('oauth_token')) {
            return ClientFacade::login();
        }

        // Second step for access token
        $auth = ClientFacade::obtainAccessToken($request->input('oauth_token'));
        $user = User::whereFellowshipOneUserId($auth['user_id'])->first();
        $claims = [
            'oauth_token'            => $auth['oauth_token'],
            'oauth_token_secret'     => $auth['oauth_token_secret'],
            'fellowship_one_user_id' => $auth['user_id']
        ];

        // Redirect to remove oauth_token URL param
        $response = redirect('requests/new'); // TODO: Needs to go to /home eventually

        if (!$user) {
            $user = new User();
            $user->id = 0;
        }

        $jwt_token = JWTAuth::fromUser($user, $claims);

        $response->withCookie(cookie()->forever('jwt', $jwt_token, null, null, false, false)); // Non HttpOnly

        return $response;
    }

    public function register(Request $request) {

        // Make sure username ends with '@faithpromise.org'
        $email = preg_replace('/(?:@faithpromise\.org)+$/', '', $request->input('username')) . '@faithpromise.org';

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('A valid Faith Promise email address is required to register.');
        }

        $data = [];
        $data['email'] = $email;
        $data['verification_token'] = 'fp-' . str_random(16);
        $data['verification_url'] = url(route('verifyEmail', ['token' => $data['verification_token']]));

        $payload = JWTAuth::parseToken()->getPayload();

        // User could verify email from a different browser/device,
        // so we need to cache all this info and not rely on JWT
        // to be passed in /verify-email request.
        Cache::put($data['verification_token'], [
            'email'                  => $data['email'],
            'oauth_token'            => $payload->get('oauth_token'),
            'oauth_token_secret'     => $payload->get('oauth_token_secret'),
            'fellowship_one_user_id' => $payload->get('fellowship_one_user_id')
        ], 5);

        Mail::send('emails.register', ['data' => $data], function ($message) use ($data) {
            $message
                ->from('dev@faithpromise.org')
                ->to($data['email'])
                ->subject('Faith Promise: Verify your email address');
        });

    }

    public function verifyEmail($verification_token) {

        $data = Cache::get($verification_token);

        if ($data) {

            $response = redirect('requests/new'); // TODO: Needs to go to /home eventually

            $user = User::whereEmail($data['email'])->first();

            // Create the user
            if (!$user) {
                $user = new User;
                $user->email = $data['email'];
                $user->password = 'login_via_f1_' . str_random(35);
            }

            $f1_user = ClientFacade::setAccessToken($data['oauth_token'], $data['oauth_token_secret'])->getPerson($data['fellowship_one_user_id']);
            $user->fellowship_one_user_id = $data['fellowship_one_user_id'];
            $user->first_name = $f1_user['firstName'];
            $user->last_name = $f1_user['lastName'];

            $user->save();

            $jwt_token = JWTAuth::fromUser($user, [
                'oauth_token'            => $data['oauth_token'],
                'oauth_token_secret'     => $data['oauth_token_secret'],
                'fellowship_one_user_id' => $data['fellowship_one_user_id']
            ]);

            $response->withCookie(cookie()->forever('jwt', $jwt_token, null, null, false, false)); // Non HttpOnly

            return $response;

        }

        return view('verify-email-expired');

    }

}
