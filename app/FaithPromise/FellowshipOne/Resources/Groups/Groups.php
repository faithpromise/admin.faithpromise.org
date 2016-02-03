<?php

namespace App\FaithPromise\FellowshipOne\Resources\Groups;

use App\FaithPromise\FellowshipOne\Models\Groups\Group;
use App\FaithPromise\FellowshipOne\Models\Groups\Gender;
use App\FaithPromise\FellowshipOne\Models\Groups\MaritalStatus;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;

class Groups extends BaseResource {

    use SearchableResource;


    /*
    |--------------------------------------------------------------------------
    | Find
    |--------------------------------------------------------------------------
    |
    | Find and return a single record
    |
    */

    public function find($id) {
        $result = $this->client->fetch('/groups/v1/groups/' . $id);

        return new Group($this->client, $result['group']);
    }


    /*
    |--------------------------------------------------------------------------
    | All
    |--------------------------------------------------------------------------
    |
    | Get all records. Should not be used with "where" methods. When searching
    | use the get() method.
    |
    | Ex: $f1->groups()->all();
    |
    */

    public function all() {

        if ($this->hasSearchParameters()) {
            throw new \Exception('You should not use all() after adding criteria. Use get() instead.');
        }

        $searchable_groups = $this->client->groups()->whereSearchable()->perPage(99999)->get();
        $hidden_groups = $this->client->groups()->whereSearchable(false)->perPage(99999)->get();

        return $searchable_groups->merge($hidden_groups);
    }

    /**
     * @param $id
     * @return \App\FaithPromise\FellowshipOne\Models\Groups\Group
     */
    public function context($id) {
        $model = new Group($this->client);

        return $model->setId($id);
    }


    /*
    |--------------------------------------------------------------------------
    | "Where" Methods
    |--------------------------------------------------------------------------
    |
    | These methods are chainable and are used to add criteria to your search.
    |
    | Ex: $f1->groups()->whereMinAge(40)->whereWomenOnly()->get();
    |
    */

    public function whereName($value) {
        return $this->addSearchParam('searchFor', $value);
    }

    public function whereSearchable($value = true) {
        return $this->addSearchParam('isSearchable', $value ? 'true' : 'false');
    }

    public function whereMenOnly() {
        return $this->addSearchParam('genderID', Gender::MALE);
    }

    public function whereWomenOnly() {
        return $this->addSearchParam('genderID', Gender::FEMALE);
    }

    public function whereCoed() {
        return $this->addSearchParam('genderID', Gender::COED);
    }

    public function whereMarriedsOnly() {
        return $this->addSearchParam('maritalStatusID', MaritalStatus::MARRIED);
    }

    public function whereSinglesOnly() {
        return $this->addSearchParam('maritalStatusID', MaritalStatus::SINGLE);
    }

    public function whereMarriedsAndSingles() {
        return $this->addSearchParam('maritalStatusID', MaritalStatus::SINGLE);
    }

    public function whereMinAge($value) {
        return $this->addSearchParam('startAgeRange', $value);
    }

    public function whereMaxAge($value) {
        return $this->addSearchParam('endAgeRange', $value);
    }

    public function whereCampus($value) {
        return $this->addSearchParam('churchCampusID', $value);
    }

    public function whereCategory($value) {
        // TODO: Categories?
        return $this->addSearchParam('categoryID', $value);
    }

    public function whereChildcare($value = true) {
        return $this->addSearchParam('hasChildcare', $value ? 'true' : 'false');
    }

    public function whereRadius($lat, $lng, $radius, $radius_unit = 'mi') {
        return $this->addSearchParam('latitude', $lat)
            ->addSearchParam('longitude', $lng)
            ->addSearchParam('radius', $radius)
            ->addSearchParam('radiusUnit', $radius_unit);
    }


    /*
    |--------------------------------------------------------------------------
    | Get
    |--------------------------------------------------------------------------
    |
    | Get the results. At least one criteria must be provided
    |
    | Ex: $f1->groups()->whereName('Betty Boops Group')->get();
    |
    */

    public function get() {

        if (!$this->hasSearchParameters()) {
            throw new \Exception('At least one criteria must be provided to search groups.');
        }

        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('recordsPerPage', $this->per_page);
        $result = $this->client->fetch('/groups/v1/groups/search?' . http_build_query($this->search_params));

        return $this->buildCollection($result['groups'], 'group', Group::class);
    }

}
