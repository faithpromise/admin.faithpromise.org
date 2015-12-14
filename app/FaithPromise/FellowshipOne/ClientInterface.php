<?php

namespace App\FaithPromise\FellowshipOne;

interface ClientInterface {

    public function login();
    public function obtainAccessToken($oauthToken);

}