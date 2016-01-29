<?php

namespace App\FaithPromise\FellowshipOne;

interface FellowshipOneInterface {

    public function login();
    public function obtainAccessToken($oauthToken);

}