<?php

namespace App\FaithPromise\FellowshipOne;

interface AuthInterface {

    public function login();
    public function obtainAccessToken($oauthToken);

}