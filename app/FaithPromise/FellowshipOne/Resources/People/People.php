<?php

namespace App\FaithPromise\FellowshipOne\Resources\People;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\People\Person;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;
use Carbon\Carbon;

class People extends BaseResource {

    use SearchableResource;

    public function __construct(FellowshipOne $f1) {

        parent::__construct($f1);

        // Include phone numbers and email by default
        $this->loadCommunications();
    }


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

        return $result ? new Person($this->client, $result['person']) : null;
    }


    /*
    |--------------------------------------------------------------------------
    | All
    |--------------------------------------------------------------------------
    |
    | Get all records. Limited to 1000. Use pagination:
    |
    |
    |   $collection = $f1->people()->all();
    |
    |   while($collection->hasMore()) {
    |
    |       $people = $collection->get();
    |
    |       foreach($people as $person) {
    |           echo $person->getName() . '<br>';
    |       }
    |   }
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

    public function noIncludes() {
        $this->loadAddresses(false);
        $this->loadAttributes(false);
        $this->loadCommunications(false);

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | "With" Methods
    |--------------------------------------------------------------------------
    |
    | With methods are chainable and are used include records that would not
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
    | Get
    |--------------------------------------------------------------------------
    |
    | Get the results. At least one criteria must be provided
    |
    | Ex: $f1->people()->withInactive()->whereName('Betty Boop')->get();
    |
    */

    public function hasMore() {

        $result = $this->client->fetch($this->getSearchUrl());
        $additional_pages = intval($result['results']['@additionalPages']);

        if ($additional_pages > 0) {
            $this->nextPage();
        }

        return $additional_pages >= 0;

    }

    public function get() {

        if (!$this->hasSearchParameters()) {
            throw new \Exception('At least one criteria must be provided to search people.');
        }

        $result = $this->client->fetch($this->getSearchUrl());

        return $this->buildCollection($result['results'], 'person', Person::class);
    }

    private function getSearchUrl() {

        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('recordsPerPage', $this->per_page);

        $params = empty($this->include_params) ? $this->search_params : array_merge($this->search_params, ['include' => implode(',', $this->include_params)]);

        return '/v1/People/Search?' . http_build_query($params);
    }

}