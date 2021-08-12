<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Jobs\CustomerJsonProcess;

class CustomerController extends Controller
{
    private $path;

    public function __construct()
    {
        $this->path = resource_path('temp');
    }

    public function index()
    {
        return view('upload_file');
    }

    public function store()
    {
        //Upload the entire file and form subset of files
        if (request()->has('myjson')) {
            //Read CSV
            // $data = fgetcsv(fopen("challenge.csv", "r"));

            //Read XML
            //$data = simplexml_load_file("challenge.xml") or die("Error: Cannot create object");

            //Read JSON
            $data = json_decode(file_get_contents(request()->myjson), true);
            // if the source file gets bigger, the jobs in the queue increases, while maintaining
            // a maximum of 100 records per job
            $chunks = array_chunk($data, 100);
            foreach ($chunks as $key => $chunk) {
                $path = $this->path . "\mytmp{$key}.json";
                file_put_contents($path, json_encode($chunk));
            }
        }

        print("Processing jobs...<br />");


        $files = glob($this->path . "/*.json");
        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);
            // php artisan queue:work
            CustomerJsonProcess::dispatch($data);
            unlink($file);
        }
    }
}
