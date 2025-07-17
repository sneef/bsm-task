<?php

namespace App\Console\Commands;

use App\Jobs\BlackScaleMedia;
use Illuminate\Console\Command;

class runBsmJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-bsm-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scrapping token from BlackScaleMedia website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //We create two parallel tasks:
        for ($i = 1; $i <= 2; $i++) {
            BlackScaleMedia::dispatch($i)
                ->onQueue('default');
            
            echo "Task #$i added to queue\n";
        }
    }
}
