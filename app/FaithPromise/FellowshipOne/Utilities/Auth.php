<?php

namespace App\FaithPromise\FellowshipOne\Utilities;

use App\FaithPromise\FellowshipOne\Exceptions\AuthException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Auth {

    const CREDENTIALS = 'credentials';
    const REMOTE = 'remote';

    /**
     * @var string
     */
    protected $authStrategy;

    /**
     * @var array
     */
    protected $authOptions;

    protected static function getValidAuthStrategies() {
        return [self::CREDENTIALS, self::REMOTE];
    }

    public function __construct($strategy, array $options = null) {

        if (! in_array($strategy, self::getValidAuthStrategies())) {
            throw new AuthException('Invalid auth strategy set, please use `' . implode('` or `', self::getValidAuthStrategies()) . '`');
        }

        if ($strategy === self::CREDENTIALS) {

            $this->requireUsernameAndPassword($options);
            $this->authenticate($options['username'], $options['password']);

        } else if ($strategy === self::REMOTE) {

            $this->requireTokens($options);
            $this->login($options['oauth_token'], $options['oauth_token_secret']);

        }

        $this->authOptions = $options;

    }

    public function prepareRequest($oauthClient) {
        $oauthClient->setToken($this->oauthToken, $this->request_token_secret);
    }

    private function login() {

    }

    private function authenticate($username, $password) {

        $key = 'f1_access_token_' . md5($username . $password);
        $expires_at = Carbon::now()->addDays(1);
        $has_existing_access_token = Cache::has($key);

        if (!$has_existing_access_token && $token = $this->obtainCredentialsBasedAccessToken($username, $password)) {
            Cache::put($key, $token, $expires_at);
        }

        if (!$token = Cache::get($key)) {
            return false;
        }

        $this->setAccessToken($token['oauth_token'], $token['oauth_token_secret']);

        return $this;

    }

    private function obtainCredentialsBasedAccessToken($username, $password) {

        try {

            $message = urlencode(base64_encode($username . ' ' . $password));
            $url = $this->build_url(self::F1_PORTAL_ACCESS_TOKEN_PATH) . '?ec=' . $message;

            $token = $this->oauthClient->getAccessToken($url);

            return $token;

        } catch (\OAuthException $e) {
            return false;
        }

    }

    private function requireUsernameAndPassword($options) {
        if (!array_key_exists('username', $options) || !array_key_exists('password', $options)) {
            throw new AuthException('Please supply `username` and `password` for credentials login.');
        }
    }

    private function requireTokens($options) {
        if (!array_key_exists('oauth_token', $options) || !array_key_exists('oauth_token_secret', $options)) {
            throw new AuthException('Please supply `token` for oauth.');
        }
    }


}