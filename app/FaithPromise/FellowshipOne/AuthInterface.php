<?php

namespace App\FaithPromise\FellowshipOne;

interface AuthInterface {

    public function obtainRequestToken();
    public function obtainAccessToken($oauthToken);

}