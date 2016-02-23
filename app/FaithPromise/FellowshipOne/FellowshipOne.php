<?php

namespace App\FaithPromise\FellowshipOne;

use App\FaithPromise\FellowshipOne\Resources\Activities\Activities;
use App\FaithPromise\FellowshipOne\Resources\Activities\Assignments;
use App\FaithPromise\FellowshipOne\Resources\Activities\Attendances;
use App\FaithPromise\FellowshipOne\Resources\Activities\HeadCounts;
use App\FaithPromise\FellowshipOne\Resources\Activities\Instances;
use App\FaithPromise\FellowshipOne\Resources\Activities\Ministries;
use App\FaithPromise\FellowshipOne\Resources\Activities\Rooms;
use App\FaithPromise\FellowshipOne\Resources\Activities\RosterFolders;
use App\FaithPromise\FellowshipOne\Resources\Activities\Rosters;
use App\FaithPromise\FellowshipOne\Resources\Activities\Schedules as ActivitySchedules;
use App\FaithPromise\FellowshipOne\Resources\Groups\MemberTypes;
use App\FaithPromise\FellowshipOne\Resources\People\Addresses;
use App\FaithPromise\FellowshipOne\Resources\People\Communications;
use App\FaithPromise\FellowshipOne\Resources\People\Denominations;
use App\FaithPromise\FellowshipOne\Resources\Events\Events;
use App\FaithPromise\FellowshipOne\Resources\Events\Schedules;
use App\FaithPromise\FellowshipOne\Resources\Groups\Categories;
use App\FaithPromise\FellowshipOne\Resources\Groups\Members;
use App\FaithPromise\FellowshipOne\Resources\Groups\Groups;
use App\FaithPromise\FellowshipOne\Resources\People\HouseholdMemberTypes;
use App\FaithPromise\FellowshipOne\Resources\People\Occupations;
use App\FaithPromise\FellowshipOne\Resources\People\People;
use App\FaithPromise\FellowshipOne\Resources\People\Households;
use App\FaithPromise\FellowshipOne\Resources\People\PersonStatuses;
use App\FaithPromise\FellowshipOne\Resources\People\Schools;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use OAuth;

class FellowshipOne implements FellowshipOneInterface {

    const F1_PORTAL_LOGIN_PATH = '/v1/PortalUser/Login';
    const F1_PORTAL_ACCESS_TOKEN_PATH = '/v1/PortalUser/AccessToken';
    const F1_REQUEST_TOKEN_PATH = '/v1/Tokens/RequestToken';
    const F1_ACCESS_TOKEN_PATH = '/v1/Tokens/AccessToken';

    protected $oauthClient;
    protected $api_url;

    public function __construct($consumer_key, $consumer_secret, $api_url) {
        $this->oauthClient = new OAuth($consumer_key, $consumer_secret);
        $this->api_url = $api_url;
    }

    public function activities() {
        return new Activities($this);
    }

    public function activityInstances($schedule_id) {
        return new Instances($this, $schedule_id);
    }

    public function activitySchedules($activity_id) {
        return new ActivitySchedules($this, $activity_id);
    }

    public function activityRosters($activity_id) {
        return new Rosters($this, $activity_id);
    }

    public function activityRosterFolders($activity_id) {
        return new RosterFolders($this, $activity_id);
    }

    public function activityHeadCounts($instance_id) {
        return new HeadCounts($this, $instance_id);
    }

    public function activityRooms() {
        return new Rooms($this);
    }

    public function addresses($person_id) {
        return new Addresses($this, $person_id);
    }

    public function assignments($activity_id) {
        return new Assignments($this, $activity_id);
    }

    public function attendances($activity_id, $instance_id) {
        return new Attendances($this, $activity_id, $instance_id);
    }

    public function communications($person_id) {
        return new Communications($this, $person_id);
    }

    public function denominations() {
        return new Denominations($this);
    }

    public function events() {
        return new Events($this);
    }

    public function eventSchedules($event_id) {
        return new Schedules($this, $event_id);
    }

    public function groups() {
        return new Groups($this);
    }

    public function groupCategories() {
        return new Categories($this);
    }

    public function groupMembers($group_id) {
        return new Members($this, $group_id);
    }

    public function groupMemberTypes() {
        return new MemberTypes($this);
    }

    public function households() {
        return new Households($this);
    }

    public function householdMemberTypes() {
        return new HouseholdMemberTypes($this);
    }

    public function ministries() {
        return new Ministries($this);
    }

    public function occupations() {
        return new Occupations($this);
    }

    public function people() {
        return new People($this);
    }

    public function personStatuses() {
        return new PersonStatuses($this);
    }

    public function schools() {
        return new Schools($this);
    }

    /**
     * Credentials based authentication
     *
     * @param $username
     * @param $password
     * @return $this
     */
    public function authenticate($username, $password) {

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

    /**
     * 3rd party (redirect) OAuth based authentication
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login() {

        $request_token_url = $this->build_url(self::F1_REQUEST_TOKEN_PATH);
        $request_token = $this->oauthClient->getRequestToken($request_token_url);
        $this->storeRequestToken($request_token);

        $login_url = $this->build_url(self::F1_PORTAL_LOGIN_PATH) . '?oauth_token=' . $request_token['oauth_token'] . '&oauth_callback=' . url(route('login'));

        return \Redirect::away($login_url);
    }

    /**
     * Second step of 3rd party (redirect) OAuth based authentication
     *
     * @param $oauthToken
     * @return array
     * @throws Exception
     */
    public function obtainAccessToken($oauthToken) {

        $request_token = $this->getStoredRequestToken($oauthToken);
        $request_token_secret = array_key_exists('oauth_token_secret', $request_token) ? $request_token['oauth_token_secret'] : null;

        try {

            $this->setAccessToken($oauthToken, $request_token_secret);
            $access_token = $this->oauthClient->getAccessToken($this->build_url(self::F1_ACCESS_TOKEN_PATH));

            return [
                'oauth_token'        => $access_token['oauth_token'],
                'oauth_token_secret' => $access_token['oauth_token_secret'],
                'user_id'            => $this->getCurrentUserIdFromHeader()
            ];

        } catch (\OAuthException $e) {

            $previous = $this->oauthClient->getLastResponse();

            throw new Exception($e->getMessage(), $e->getCode(), $previous, ['url' => self::F1_ACCESS_TOKEN_PATH], $e);
        }

    }

    public function setAccessToken($oauthToken, $request_token_secret) {
        $this->oauthClient->setToken($oauthToken, $request_token_secret);

        return $this;
    }

    public function getCurrentUserIdFromHeader() {

        $location_header = $this->getContentLocationHeader();
        preg_match('/[0-9]+$/', $location_header, $matches);

        return $matches[0];
    }

    public function getPerson($id) {
        $url = $this->build_url('/v1/People/' . $id);
        $person = $this->fetch($url);

        return $person['person'];
    }

    public function fetchImage($uri, $contentType = 'image/jpeg') {
        return $this->fetch($uri, null, OAUTH_HTTP_METHOD_GET, $contentType);
    }

    public function fetch($uri, $data = null, $method = OAUTH_HTTP_METHOD_GET, $contentType = 'application/json', $retryCount = 0) {

        $uri = $this->build_url($uri);

        $headers = ['Content-Type' => $contentType];

        if (preg_match('[array|object]', gettype($data))) {
            $data = json_encode($data);
        }

        $cache_key = md5($uri . $data . $method . $retryCount);

        if (Cache::has($cache_key)) {
            var_dump($uri . ' (cached)');
            return Cache::get($cache_key);
        }

        $this->oauthClient->disableSSLChecks();

        try {

            $this->oauthClient->fetch($uri, $data, $method, $headers);

            if (strcasecmp($contentType, 'application/json') === 0) {
                Cache::put($cache_key, json_decode($this->oauthClient->getLastResponse(), true), 480);
            } else {
                Cache::put($cache_key, $this->oauthClient->getLastResponse(), 480);
            }

            return Cache::get($cache_key);

        } catch (\OAuthException $e) {

            if ($e->getCode() === 404) {
                return null;
            }

            // TODO: Retry like F1api-php5? They look for 400 though, which means don't try again without modifications

            $extra = [
                'data'       => $data,
                'url'        => $uri,
                'method'     => $method,
                'headers'    => $this->getLastResponseHeaders(),
                'retryCount' => $retryCount,
            ];

            throw new Exception($e->getMessage(), $e->getCode(), $this->oauthClient->getLastResponse(), $extra, $e);
        }

    }

    private function build_url($path) {
        if (stripos($path, $this->api_url) === 0) {
            return $path;
        }

        return preg_replace('/\/v1$/', '', $this->api_url) . $path;
    }

    private function getContentLocationHeader() {

        $headers = $this->getLastResponseHeaders();

        return isset($headers['Content-Location']) ? $headers['Content-Location'] : null;
    }

    /**
     * @return array
     */
    private function getLastResponseHeaders() {

        $header_str = $this->oauthClient->getLastResponseHeaders();
        $headers = [];
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header_str));

        foreach ($fields as $field) {
            if (preg_match('/([^:]+): (.+)/m', $field, $match)) {
                $match[1] = preg_replace_callback('/(?<=^|[\x09\x20\x2D])./', function ($m) {
                    return strtoupper($m[0]);
                }, strtolower(trim($match[1])));
                if (isset($headers[$match[1]])) {
                    $headers[$match[1]] = [$headers[$match[1]], $match[2]];
                } else {
                    $headers[$match[1]] = trim($match[2]);
                }
            }
        }

        return $headers;
    }

    private function getStoredRequestToken($oauth_token) {

        $key = $oauth_token;

        return Cache::get($key);
    }

    private function storeRequestToken($value) {

        $key = $value['oauth_token'];
        Cache::put($key, $value, 5);

        return $this;
    }

}