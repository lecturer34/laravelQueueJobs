<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use Carbon\Carbon;

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

        $dataInsert = [];
        foreach ($this->data as $datum) {
            $name = $datum["name"];
            $address = $datum["address"];
            $checked = $datum["checked"];
            $description = $datum["description"];
            $interest = $datum["interest"];
            $date_of_birth = $datum["date_of_birth"];
            $email = $datum["email"];
            $account = $datum["account"];
            $credit_card_number = $datum["credit_card"]["number"];

            if (!empty(trim($date_of_birth))) {
                $datetime = strtotime(str_replace('/', '-', $date_of_birth));
                $datetime = new Carbon($datetime);
                $yearsfromnow = $datetime->diffInYears();

                if ($yearsfromnow >= 18 && $yearsfromnow <= 65) { //Checks if age is between 18 and 65
                    $re = '/(\d)+\1\1+/';
                    $str = $credit_card_number;

                    // if (preg_match($re, $str) == 1) { //checks if credit_card_number has at least three identical digits in	sequence
                    $dataInsert[] = [
                        'name' => $name,
                        'address' => $address,
                        'checked' => $checked,
                        'description' => $description,
                        'interest' => $interest,
                        'date_of_birth' => $date_of_birth,
                        'email' => $email,
                        'account' => $account,
                        'credit_card_number' => $credit_card_number
                    ];
                    // }
                }
            }
        }
        Customer::upsert($dataInsert, ["email"], ['name', 'address', 'checked', 'description', 'interest', 'date_of_birth', 'account', 'credit_card_number']);
    }
}
