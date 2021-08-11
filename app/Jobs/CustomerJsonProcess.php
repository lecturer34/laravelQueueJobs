<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;

class CustomerJsonProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */



    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->data as $datum) {
            Customer::create([
                'name' => $datum["name"],
                'address' => $datum["address"],
                'checked' => $datum["checked"],
                'description' => $datum["description"],
                'interest' => (!isset($datum["interest"])) ? 0 : 1, //Values from this field need preprocessing
                'date_of_birth' => (!isset($datum["date_of_birth"])) ? 0 : 1, //Values from this field need preprocessing
                'email' => $datum["email"],
                'account' => $datum["account"]
            ]);
        }
    }
}
