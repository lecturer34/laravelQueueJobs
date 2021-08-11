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
            $data = json_decode(file_get_contents(request()->myjson), true);
            $chunks = array_chunk($data, 100);
            foreach ($chunks as $key => $chunk) {
                $path = $this->path . "\mytmp{$key}.json";
                file_put_contents($path, json_encode($chunk));
            }
        }

        print("Processing jobs...<br />");

        //Place jobs to be processed in a queue and remove the subset of files from directory
        $files = glob($this->path . "/*.json");
        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);
            CustomerJsonProcess::dispatch($data);
            unlink($file);
        }
    }
}
