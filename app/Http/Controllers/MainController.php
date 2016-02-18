<?php

namespace App\Http\Controllers;

use App\FaithPromise\FellowshipOne\FellowshipOneFacade;
use App\FaithPromise\FellowshipOne\Models\Groups\Group;
use App\FaithPromise\FellowshipOne\Models\Groups\Type;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MainController extends BaseController {

    public function index() {
        return view('index');
    }

    public function test() {

        /** @var \App\FaithPromise\FellowshipOne\FellowshipOne $f1 */
        $f1 = FellowshipOneFacade::authenticate(
            config('fellowshipone.username'),
            config('fellowshipone.password')
        );

        /**
         * Group IDs: 1906648
         * Household IDs: 7871147,47232278,33807856,11883428
         *
         * Ministry: 9701 (PEL - Student Ministries)
         * Activity: 27043 (fpStudents High School)
         * Schedule: 47102 (Wednesday, 6:30 PM)
         */

        if ($f1) {

//            $test = $f1->events()->all()->filter(function($item) {
//                return stripos($item->getName(), 'Gilbert') !== false;
//            });

            $test = $f1->groups()->perPage(5)->whereCategory(7079)->get();

            /** @var Group $group */
            foreach($test as $group) {
                echo $group->getName() . $group->getGroupType()->getName() . '<br>';
            }
            dd('done');


            $test = $f1->groupCategories()->all();
            /** @var Type $type */
            foreach($test as $type) {
                echo $type->getId() . ' - ' . $type->getName() . '<br>';
            }
            dd('done');

            /** @var Group $group */
            foreach($test as $group) {
                echo $group->getName() . $group->getGroupType()->getName() . '<br>';
            }

            dd('done');
            $test = $f1->groups()->find(1906648)->getLeaders(true);
//            $test = $f1->groupMemberTypes()->all();

            dd($test);




            $test = $f1->assignments()->all();

            foreach($test as $min) {
                if ($min->getName() == 'PEL - Student Ministries') {
                    dd($min);
                }
            }

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
