<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\Models\Person;
use Carbon\Carbon;

class People extends BaseResource {

    // Include phone numbers and email by default
    protected $include_params = ['communications'];

    protected $search_params = [];


    /*
    |--------------------------------------------------------------------------
    | Find
    |--------------------------------------------------------------------------
    |
    | Find and return a single record
    |
    */

    public function find($id) {
        $result = $this->client->fetch('/v1/People/' . $id);

        return new Person($result['person']);
    }


    /*
    |--------------------------------------------------------------------------
    | All
    |--------------------------------------------------------------------------
    |
    | Get all records.
    |
    */

    public function all() {
        return $this->addSearchParam(
            'createdDate',
            Carbon::now()->firstOfYear()->subYears(50)->format('Y-m-d')
        )->get();
    }


    /*
    |--------------------------------------------------------------------------
    | "By" Methods
    |--------------------------------------------------------------------------
    |
    | These methods will immediately return results.
    |
    | Ex: $f1->people()->byBirthDate('1977-01-16');
    |
    */

    public function byId(array $ids) {
        return $this->addSearchParam('id', implode(',', $ids))->get();
    }

    public function byHousehold($id) {
        return $this->addSearchParam('hsdid', $id)->get();
    }

    public function byBirthDate($date) {
        return $this->addDateParam('dob', $date)->get();
    }

    public function byCreatedAfter($date) {
        return $this->addDateParam('createdDate', $date)->get();
    }

    public function byUpdatedAfter($date) {
        return $this->addDateParam('lastUpdatedDate', $date)->get();
    }

    public function byCheckInTag($id) {
        return $this->addSearchParam('checkinTagCode', $id)->get();
    }

    public function byBarCode($id) {
        return $this->addSearchParam('barCode', $id)->get();
    }

    public function byMemberNumber($id) {
        return $this->addSearchParam('memberEnvNo', $id)->get();
    }


    /*
    |--------------------------------------------------------------------------
    | "Where" Methods
    |--------------------------------------------------------------------------
    |
    | These methods are chainable and are used to add criteria to your search.
    |
    | Ex: $f1->people()->whereName('Betty Boop')->wherePhone('5551234')->get();
    |
    */

    public function whereName($value) {
        return $this->addSearchParam('searchFor', $value);
    }

    public function wherePhone($value) {
        return $this->addSearchParam('communication', $value);
    }

    public function whereAddress($value) {
        return $this->addSearchParam('address', $value);
    }

    public function whereStatus($value) {
        return $this->addSearchParam('status', $value);
    }

    public function whereAttribute($value) {
        return $this->addSearchParam('attribute', $value);
    }


    /*
    |--------------------------------------------------------------------------
    | "Load" Methods
    |--------------------------------------------------------------------------
    |
    | These methods are chainable and are used include additional "side loaded"
    | data along with the results.
    |
    | Ex: $f1->people()->loadAddresses()->whereName('Betty Boop')->get();
    |
    */

    public function loadAddresses($include = true) {
        return $this->toggleInclude('addresses', $include);
    }

    public function loadAttributes($include = true) {
        return $this->toggleInclude('attributes', $include);
    }

    public function loadCommunications($include = true) {
        return $this->toggleInclude('communications', $include);
    }


    /*
    |--------------------------------------------------------------------------
    | "With" Methods
    |--------------------------------------------------------------------------
    |
    | Where methods are chainable and are used include records that would not
    | be returned by default.
    |
    | Ex: $f1->people()->withInactive()->whereName('Betty Boop')->get();
    |
    */

    public function withInactive($include = true) {
        return $this->toggleSearchParam('includeInactive', 'True', $include);
    }

    public function withDeceased($include = true) {
        return $this->toggleSearchParam('includeDeceased', 'True', $include);
    }


    /*
    |--------------------------------------------------------------------------
    | Pagination methods
    |--------------------------------------------------------------------------
    |
    | Used to set the number of records returned in each page set.
    |
    | Ex: $f1->people()->perPage(100)->whereName('Betty Boop')->get();
    |
    */

    public function perPage($qty) {
        $this->per_page = $qty;
    }

    public function page($page) {
        $this->page = $page;
    }


    /*
    |--------------------------------------------------------------------------
    | Get
    |--------------------------------------------------------------------------
    |
    | Get the results. At least one criteria must be provided
    |
    | Ex: $f1->people()->withInactive()->whereName('Betty Boop')->get();
    |
    */

    public function get() {

        if (empty($this->search_params)) {
            throw new \Exception('At least one criteria must be provided to search people.');
        }

        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('recordsPerPage', $this->per_page);
        $params = array_merge($this->search_params, ['include' => implode(',', $this->include_params)]);
        $result = $this->client->fetch('/v1/People/Search?' . http_build_query($params));

        return $this->buildCollection($result['results']['person'], Person::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    |
    */

    private function addSearchParam($name, $value) {
        $this->search_params[$name] = $value;

        return $this;
    }

    private function removeSearchParam($name) {
        unset($this->search_params[$name]);

        return $this;
    }

    private function addDateParam($name, $value) {
        $date = new Carbon($value);

        return $this->addSearchParam($name, $date->format('Y-m-d'));
    }

    private function toggleSearchParam($name, $value, $include) {
        if ($include)
            return $this->addSearchParam($name, $value);

        return $this->removeSearchParam($name);
    }

    private function toggleInclude($value, $include = true) {

        if ($include && !in_array($value, $this->include_params)) {
            array_push($this->include_params, $value);
        } else if (!$include && in_array($value, $this->include_params)) {
            unset($this->include_params[array_search($value, $this->include_params)]);
        }

        return $this;
    }

}