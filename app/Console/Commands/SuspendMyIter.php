<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SuspendMyIter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suspendmyiter:destroy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This call a signal to interupt the current process';

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

    public function sig_handler($signo)
    {
        $this->info("Caught a signal...");
        exit;
    }

    public function handle()
    {
        pcntl_signal(SIGTERM, [$this, "sig_handler"]);
        return 0;
    }
}
