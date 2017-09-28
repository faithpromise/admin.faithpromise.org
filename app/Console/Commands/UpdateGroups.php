<?php

namespace App\Console\Commands;

use App\FaithPromise\FellowshipOne\FellowshipOneFacade;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Phaza\LaravelPostgis\Geometries\Point;

class UpdateGroups extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        /** @var \App\FaithPromise\FellowshipOne\FellowshipOne $f1 */
        $f1 = FellowshipOneFacade::authenticate(
            config('fellowshipone.username'),
            config('fellowshipone.password')
        );

        $groups = Group::stale()->limit(1)->get();

        /** @var Group $group */
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

            $group->name = $f1_group->getName();
            $group->leaders = json_encode($leaders);
            $group->description = $f1_group->getDescription();
            $group->kids_welcome = $f1_group->getHasChildcare();
            $group->average_age = $f1_group->getAverageAge();
            $group->kids_min_age = $f1_group->getMinChildAge();
            $group->kids_max_age = $f1_group->getMaxChildAge();
            $group->location = new Point($f1_group->getLatitude(), $f1_group->getLongitude());
            $group->recurrence_rule = $f1_group->getRecurrenceRule();
            $group->address = $f1_group->getAddress();
            $group->city = $f1_group->getCity();
            $group->state = $f1_group->getState();
            $group->zip = substr($f1_group->getZip(), 0, 5);
            $group->is_location_public = $f1_group->getIsLocationPublic();
            $group->detail_last_updated = Carbon::now();

            $group->save();

        }

    }
}
