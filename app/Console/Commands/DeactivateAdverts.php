<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeactivateAdverts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactivate:advert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate adverts that have reached expiry';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $adverts=Advertisement::where('expiry','<',Carbon::today())->get();
        foreach ($adverts as $advert){
            $advert->update(['status',0]);
        }
        return Command::SUCCESS;
    }
}
