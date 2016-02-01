<?php

namespace App\Http\Controllers;

use App\FaithPromise\FellowshipOne\FellowshipOneFacade;
use App\FaithPromise\FellowshipOne\Models\Groups\Group;
use App\FaithPromise\FellowshipOne\Models\People\Person;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MainController extends BaseController {

    public function index() {
        return view('index');
    }

    public function test(Request $request) {

        /** @var \App\FaithPromise\FellowshipOne\FellowshipOne $f1 */
        $f1 = FellowshipOneFacade::authenticate(
            env('F1_USERNAME'),
            env('F1_PASSWORD')
        );

        /**
         * Group IDs: 1906648
         * Household IDs: 7871147,47232278,33807856,11883428
         */

        if ($f1) {

//            $test = $f1->events()->all()->filter(function($item) {
//                return stripos($item->getName(), 'Gilbert') !== false;
//            });
            $test = $f1->groupCategories()->find(14043);
            dd($test);




//            $test = $f1->households()->context(11883428)->getVisitors();

            $test = $f1->groups()->find(1906648);
            dd($test);



            dd($test->first() . ' / ' . $test->last());


//
//            /** @var Person $person */
//            foreach($test as $person) {
//                var_dump($person->getFullName());
//            }

//            $test = $f1->personStatuses()->all();
//            $test = $f1->householdMemberTypes()->all();





//            $test = $f1->people()->all();
//            $test = $f1->households()->find(15744080);
            dd($test);
//            $test = $f1->groups()->all();

//            $test = $f1->households()->whereName('Gilbert');
//            $test = $f1->people()->findByHousehold(39085067)->first();
//            $test = $f1->people()->findByGroup(1906648);

            $test = $f1->groupMembers(1906648)->all();

//            $test->each(function($item) {
//                var_dump($item->getPerson()->getName());
//            });

//            $test = $f1->groups()->find(615294);
            dd($test);










//            $test = $f1->groupCategories()->all();
//            $test = $f1->groups()->all();
            $test = $f1->groups()->find(615294);

//            $test = $f1->groupMembers()->all(615315);
//            $test = $f1->people()->find(29494538);
            $test = $f1->households()->people(18647652);




        } else {
            $test = 'Not logged in';
        }

        dd($test);

//        $jwt_token = $request->cookie('jwt');
//        $jwt = JWTAuth::getPayload($jwt_token);
//
//        $oauth_token = $jwt->get('oauth_token');
//        $oauth_token_secret = $jwt->get('oauth_token_secret');
//
//        $test = ClientFacade::setAccessToken($oauth_token, $oauth_token_secret)->groupCategories();
//
//        dd($test);

    }

}
