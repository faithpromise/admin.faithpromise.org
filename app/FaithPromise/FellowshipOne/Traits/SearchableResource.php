<?php

namespace App\FaithPromise\FellowshipOne\Traits;

use Carbon\Carbon;

trait SearchableResource {

    protected $page = 1;
    protected $per_page = 1000;
    protected $search_params = [];
    protected $include_params = [];

    protected function hasSearchParameters() {
        return count($this->search_params) > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Search parameter methods
    |--------------------------------------------------------------------------
    |
    | Used by implementing class to add criteria to the search
    |
    */

    protected function addSearchParam($name, $value) {
        $this->search_params[strtolower($name)] = $value;

        return $this;
    }

    protected function removeSearchParam($name) {
        unset($this->search_params[strtolower($name)]);

        return $this;
    }

    protected function addDateParam($name, $value) {
        $date = new Carbon($value);
        $this->addSearchParam($name, $date->format('Y-m-d'));

        return $this;
    }

    protected function toggleSearchParam($name, $value, $include) {
        if ($include)
            return $this->addSearchParam($name, $value);

        return $this->removeSearchParam($name);
    }

    protected function toggleInclude($value, $include = true) {

        $value = strtolower($value);

        if ($include && !in_array($value, $this->include_params)) {
            array_push($this->include_params, $value);
        } else if (!$include && in_array($value, $this->include_params)) {
            unset($this->include_params[array_search($value, $this->include_params)]);
        }

        return $this;
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

        return $this;
    }

    public function page($page) {
        $this->page = $page;

        return $this;
    }

    public function nextPage() {
        $this->page++;

        return $this;
    }

}