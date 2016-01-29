<?php

namespace App\FaithPromise\FellowshipOne\Resources;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use App\FaithPromise\FellowshipOne\Models\Household;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Households extends BaseResource {

    public function __construct(FellowshipOne $f1) {
        parent::__construct($f1);
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
        return $this->find($id, true);
    }

    public function whereId(array $ids) {

        $result = new Collection();

        foreach($ids as $id) {
            $result->put($id, $this->find($id));
        }

        return $result;
    }

    public function whereName($name) {
        return $this->search('/v1/Households/Search?searchfor=' . urlencode($name));
    }

    public function whereLastActivityBefore($date) {
        $d = new Carbon($date);

        return $this->search('/v1/Households/Search?lastActivityDate=' . $d->format('Y-m-d'));
    }

    public function whereLastUpdatedBefore($date) {
        $d = new Carbon($date);

        return $this->search('/v1/Households/Search?lastUpdatedDate=' . $d->format('Y-m-d'));
    }

    public function whereCreatedBefore($date) {
        $d = new Carbon($date);

        return $this->search('/v1/Households/Search?createdDate=' . $d->format('Y-m-d'));
    }

    private function search($url) {
        $result = $this->client->fetch($url . '&recordsPerPage=5'); // TODO: Change back to 99999
        return $this->buildCollection($result['results']['household'], Household::class);
    }

}