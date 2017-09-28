<?php

namespace App\FaithPromise\FellowshipOne;

use Illuminate\Support\Facades\Facade;

class FellowshipOneFacade extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return FellowshipOneInterface::class;
    }
}
