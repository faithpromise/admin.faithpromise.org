<?php

namespace App\Http\Controllers;

use App\FaithPromise\FellowshipOne\FellowshipOneFacade;
use App\FaithPromise\FellowshipOne\Models\Groups\Group as FellowshipOneGroup;
use App\FaithPromise\FellowshipOne\Models\Groups\Type;
use App\Models\Group;
use Carbon\Carbon;
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

        // Get all searchable groups
        $f1_groups = $f1->groups()->whereSearchable()->get();

        // Delete groups that do not appear in results
        Group::whereNotIn('id', array_pluck($f1_groups->toArray(), 'id'));

        /** @var FellowshipOneGroup $f1_group */
        foreach ($f1_groups as $f1_group) {
            $group = Group::firstOrNew(['id' => $f1_group->getId()]);
            $group->name = $f1_group->getName();
            $group->save();
        }

        dd('done');

    }

    public function test2() {

        /** @var \App\FaithPromise\FellowshipOne\FellowshipOne $f1 */
        $f1 = FellowshipOneFacade::authenticate(
            config('fellowshipone.username'),
            config('fellowshipone.password')
        );

//        $test = $f1->fetch('/v1/Communications/CommunicationTypes/5');
//
//        dd($test);

        $groups = Group::stale()->limit(1)->get();

        foreach ($groups as $group) {

            $f1_group = $f1->groups()->find($group->id);

            if (is_null($f1_group)) {
                Group::whereId($group->id)->delete();
                continue;
            }

            $leaders = [];
            foreach ($f1_group->getLeaders(true) as $leader) {
                $leaders[] = [
                    'first_name' => $leader->getPerson()->getFirstName(),
                    'last_name'  => $leader->getPerson()->getLastName(),
                    'name'       => $leader->getPerson()->getName(),
                    'email'      => $leader->getPerson()->getPreferredEmail(),
                    'phone'      => $leader->getPerson()->getMobilePhone()
                ];
            }

//            dd($f1_group->getLeaders(true)->first()->getPerson()->getName());

            $group->name = $f1_group->getName();
            $group->leaders = json_encode($leaders);
            $group->description = $f1_group->getDescription();
            $group->kids_welcome = $f1_group->getHasChildcare();
            $group->average_age = $f1_group->getAverageAge();
            $group->kids_min_age = $f1_group->getMinChildAge();
            $group->kids_max_age = $f1_group->getMaxChildAge();
            $group->recurrence_rule = $f1_group->getRecurrenceRule();
            $group->address = $f1_group->getAddress();
            $group->city = $f1_group->getCity();
            $group->state = $f1_group->getState();
            $group->zip = substr($f1_group->getZip(), 0, 5);
            $group->is_location_public = $f1_group->getIsLocationPublic();
            $group->detail_last_updated = Carbon::now();

            $group->save();

        }

        dd($groups);

    }

    public function test3() {


        /** @var \App\FaithPromise\FellowshipOne\FellowshipOne $f1 */
        $f1 = FellowshipOneFacade::authenticate(
            config('fellowshipone.username'),
            config('fellowshipone.password')
        );

        /**
         * Group IDs: 1906648,1940691
         * Household IDs: 7871147,47232278,33807856,11883428
         *
         * Ministry: 9701 (PEL - Student Ministries)
         * Activity: 27043 (fpStudents High School)
         * Schedule: 47102 (Wednesday, 6:30 PM)
         */

        if ($f1) {

            $test = $f1->fetch('/events/v1/events/351615/schedules');

            dd($test);

//            $test = $f1->households()->find(7871147)->getFamilyMembers();

            var_dump('done');
            dd($test);

//            $test = $f1->fetch('/groups/v1/timezones');
//            foreach($test['timezones']['timezone'] as $tz) {
//                echo '//const CONSTANT_NAME = ' . $tz['@id'] . '; // ' . $tz['name'] . '<br>';
//            }
//            dd($test);

//            $test = $f1->events()->all()->filter(function($item) {
//                return stripos($item->getName(), 'Gilbert') !== false;
//            });

            $test = $f1->groups()->find(1940691)->getSchedule();
            dd($test);

            /** @var Group $group */
            foreach ($test as $group) {
                echo $group->getName() . $group->getGroupType()->getName() . '<br>';
            }
            dd('done');


            $test = $f1->groupCategories()->all();
            /** @var Type $type */
            foreach ($test as $type) {
                echo $type->getId() . ' - ' . $type->getName() . '<br>';
            }
            dd('done');

            /** @var Group $group */
            foreach ($test as $group) {
                echo $group->getName() . $group->getGroupType()->getName() . '<br>';
            }

            dd('done');
            $test = $f1->groups()->find(1906648)->getLeaders(true);
//            $test = $f1->groupMemberTypes()->all();

            dd($test);


            $test = $f1->assignments()->all();

            foreach ($test as $min) {
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
