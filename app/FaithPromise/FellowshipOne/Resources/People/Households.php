<?php

namespace App\FaithPromise\FellowshipOne\Resources\People;

use App\FaithPromise\FellowshipOne\Models\People\Household;
use App\FaithPromise\FellowshipOne\Resources\BaseResource;
use App\FaithPromise\FellowshipOne\Traits\SearchableResource;
use Illuminate\Support\Collection;

class Households extends BaseResource {

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
        $result = $this->client->fetch('/v1/Households/' . $id);

        return new Household($this->client, $result['household']);
    }

    /**
     * @param $id
     * @return Household
     */
    public function context($id) {
        $model = new Household($this->client);

        return $model->setId($id);
    }

    public function edit($id) {
        return $this->find($id);
    }


    /*
    |--------------------------------------------------------------------------
    | "By" Methods
    |--------------------------------------------------------------------------
    |
    | These methods will immediately return results.
    |
    | Ex: $f1->groups()->byName('Betty Boop');
    |
    */

    public function byId(array $ids) {
        $result = new Collection();

        foreach ($ids as $id) {
            $result->put($id, $this->find($id));
        }

        return $result;
    }

    public function byName($value) {
        return $this->addSearchParam('searchfor', $value)->get();
    }

    public function byLastActivityBefore($value) {
        return $this->addDateParam('lastActivityDate', $value)->get();
    }

    public function byLastUpdatedBefore($value) {
        return $this->addDateParam('lastUpdatedDate', $value)->get();
    }

    public function byCreatedBefore($value) {
        return $this->addDateParam('createdDate', $value)->get();
    }

    public function get() {

        if (empty($this->search_params)) {
            throw new \Exception('At least one criteria must be provided to search households.');
        }

        $this->addSearchParam('page', $this->page);
        $this->addSearchParam('recordsPerPage', $this->per_page);
        $result = $this->client->fetch('/v1/Households/Search?' . http_build_query($this->search_params));

        return $this->buildCollection($result['results'], 'household', Household::class);
    }

}