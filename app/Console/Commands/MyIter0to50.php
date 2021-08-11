<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MyIter0to50 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myiter0to50:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'An iteration from 0 to 50';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        for ($i=0; $i<50; $i++){
            sleep(1);
            $this->info($i);
        }
    }
}
