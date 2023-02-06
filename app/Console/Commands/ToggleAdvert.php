<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ToggleAdvert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toggle:advert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Toggles the state of each advert available on the system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*
         * Toggle advert based on the start and end date.
         * An advert will exist in three status:
         * Active, Inactive, Scheduled,
         * This command will toggle status from scheduled to active if the start date is today.
         * The command should be executed on a daily basis.
         * It will also toggle active commands to inactive when the end date is reached
         * Status:
         * 0-Inactive
         * 1-Active
         * 2-Scheduled
         */

        $adverts=Advertisement::where('status',2)->where('start',Carbon::today())->get();
        foreach ($adverts as $advert){
            $advert->update(['status'=>1]);
        }
        $active=Advertisement::where('status',1)->where('expiry',Carbon::today())->get();
        foreach ($active as $ad){
            $ad->update(['status'=>0]);
        }

        return "Success";
    }
}
