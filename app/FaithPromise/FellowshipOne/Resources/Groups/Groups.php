<?php

namespace App\FaithPromise\FellowshipOne\Resources\Groups;

use App\FaithPromise\FellowshipOne\Models\Groups\Group;
use App\FaithPromise\FellowshipOne\Models\Groups\Gender;
use App\FaithPromise\FellowshipOne\Models\Groups\MaritalStatus;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;

class Groups extends BaseResource {

    use SearchableResource;

    public function all() {

        return $this->whereMinAge(50)->whereMaxAge(100)->get();
        // TODO: Fix
//        $result = $this->client->fetch('/groups/v1/groups/search?issearchable=true&recordsPerPage=5');
//        return $this->buildCollection($result['groups']['group'], Group::class);
    }

    public function find($id) {
        $result = $this->client->fetch('/groups/v1/groups/' . $id);

        return new Group($this->client, $result['group']);
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

    public function whereSearchable() {
        return $this->addSearchParam('isSearchable', 'true');
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

        if (empty($this->search_params)) {
            throw new \Exception('At least one criteria must be provided to search groups.');
        }

        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('recordsPerPage', $this->per_page);
        $result = $this->client->fetch('/groups/v1/groups/search?' . http_build_query($this->search_params));

        return $this->buildCollection($result['groups'], 'group', Group::class);
    }

}
