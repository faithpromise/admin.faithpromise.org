<?php

namespace App\Console\Commands;

use App\FaithPromise\FellowshipOne\FellowshipOneFacade;
use App\FaithPromise\FellowshipOne\Models\Groups\Group as FellowshipOneGroup;
use App\Models\Group; // TODO: Switch to shared when we create it
use Illuminate\Console\Command;
use Phaza\LaravelPostgis\Geometries\Point;

class ImportGroups extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports Groups from Fellowship One';

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

        // Get all searchable groups
        $f1_groups = $f1->groups()->whereSearchable()->get();

        // Delete groups that do not appear in results
        Group::whereNotIn('id', array_pluck($f1_groups->toArray(), 'id'));

        /** @var FellowshipOneGroup $f1_group */
        foreach ($f1_groups as $f1_group) {
            // TODO: Determine if group is inactive (ended) and delete it if so
            $group = Group::firstOrNew(['id' => $f1_group->getId()]);
            $group->name = $f1_group->getName();
            $group->location = new Point($f1_group->getLatitude(), $f1_group->getLongitude());
            $group->is_location_public = $f1_group->getIsLocationPublic();
            $group->save();
        }

    }
}
